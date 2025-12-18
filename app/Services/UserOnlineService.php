<?php


namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class UserOnlineService
{
    /**
     * 缓存相关常量
     */
    private const CACHE_PREFIX = 'ALIVE_IP_USER_';
    private const DATA_EXPIRY = 30;

    /**
     * 获取所有限制设备用户的在线数量
     */
    public function getAliveList(Collection $deviceLimitUsers): array
    {
        if ($deviceLimitUsers->isEmpty()) {
            return [];
        }

        $cacheKeys = $deviceLimitUsers->pluck('id')
            ->map(fn(int $id): string => self::CACHE_PREFIX . $id)
            ->all();

        return collect(cache()->many($cacheKeys))
            ->filter()
            ->map(fn(array $data): int => self::calculateDeviceCount($data))
            ->filter()
            ->mapWithKeys(fn(int $count, string $key): array => [
                (int) Str::after($key, self::CACHE_PREFIX) => $count
            ])
            ->all();
    }

    /**
     * 获取指定用户的在线设备信息
     */
    public static function getUserDevices(int $userId): array
    {
        $data = cache()->get(self::CACHE_PREFIX . $userId, []);
        if (empty($data)) {
            return ['total_count' => 0, 'devices' => []];
        }

        $devices = collect($data)
            ->filter(fn(mixed $item): bool => is_array($item) && isset($item['aliveips']) && isset($item['lastupdateAt']) && (time() - $item['lastupdateAt'] < self::DATA_EXPIRY))
            ->flatMap(function (array $nodeData, string $nodeKey): array {
                return collect($nodeData['aliveips'])
                    ->mapWithKeys(function (string $ipNodeId) use ($nodeData, $nodeKey): array {
                        $ip = Str::before($ipNodeId, '_');
                        return [
                            $ip => [
                                'ip' => $ip,
                                'last_seen' => $nodeData['lastupdateAt'],
                                'node_type' => Str::before($nodeKey, (string) $nodeData['lastupdateAt'])
                            ]
                        ];
                    })
                    ->all();
            })
            ->values()
            ->all();

        return [
            'total_count' => self::calculateDeviceCount($data),
            'devices' => $devices
        ];
    }


    /**
     * 批量获取用户在线设备数
     */
    public function getOnlineCounts(array $userIds): array
    {
        $cacheKeys = collect($userIds)
            ->map(fn(int $id): string => self::CACHE_PREFIX . $id)
            ->all();

        return collect(cache()->many($cacheKeys))
            ->filter()
            ->map(fn(array $data): int => self::calculateDeviceCount($data))
            ->all();
    }

    /**
     * 获取用户在线设备数
     */
    public function getOnlineCount(int $userId): int
    {
        $data = cache()->get(self::CACHE_PREFIX . $userId, []);
        return self::calculateDeviceCount($data);
    }

    /**
     * 计算在线设备数量
     */
    public static function calculateDeviceCount(array $ipsArray): int
    {
        $mode = (int) admin_setting('device_limit_mode', 0);

        // Remove 'alive_ip' key if exists to avoid processing it
        unset($ipsArray['alive_ip']);

        $result = match ($mode) {
            // Mode 1: Count unique IPs per node (relaxed mode)
            // Same IP on different nodes = multiple devices
            1 => collect($ipsArray)
                ->filter(fn(mixed $data): bool => is_array($data) && isset($data['aliveips']) && isset($data['lastupdateAt']) && (time() - $data['lastupdateAt'] < self::DATA_EXPIRY))
                ->flatMap(
                    fn(array $data): array => collect($data['aliveips'])
                        ->map(fn(string $ipNodeId): string => Str::before($ipNodeId, '_'))
                        ->unique()
                        ->all()
                )
                ->unique()
                ->count(),
            // Mode 0 & default: Count by node connections (optimized mode)
            // Each node with connections = 1 device
            // Same user on same node = 1 device, different node = another device
            default => collect($ipsArray)
                ->filter(fn(mixed $data): bool => is_array($data) && isset($data['aliveips']) && !empty($data['aliveips']) && isset($data['lastupdateAt']) && (time() - $data['lastupdateAt'] < self::DATA_EXPIRY))
                ->count(),
        };

        // Debug logging (only log if processing actual data)
        if (!empty($ipsArray)) {
            $allIps = collect($ipsArray)
                ->filter(fn(mixed $data): bool => is_array($data) && isset($data['aliveips']) && isset($data['lastupdateAt']) && (time() - $data['lastupdateAt'] < self::DATA_EXPIRY))
                ->flatMap(fn(array $data): array => $data['aliveips'])
                ->map(fn(string $ipNodeId): string => Str::before($ipNodeId, '_')) 
                ->unique()
                ->values()
                ->all();
        }
        return $result;
    }
}
