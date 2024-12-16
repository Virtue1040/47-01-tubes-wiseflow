<?php

namespace App\Services;

use GetStream\StreamChat\Client;
use Illuminate\Support\Facades\Auth;

class StreamChatService
{
    public $client;

    public function __construct()
    {
        $this->client = new Client(env('STREAM_API_KEY'), env('STREAM_API_SECRET'));
    }

    public function createUser($userId, $name, $imagePath)
    {
        return $this->client->upsertUser([
            'id' => $userId,
            'name' => $name,
            'role' => 'user',
            'image' => $imagePath,
        ]);
    }

    public function createToken($userId)
    {
        return $this->client->createToken($userId);
    }

    public function getUserChannels($userId)
    {

        $channels = $this->client->queryChannels([
            'members' => ['$in' => [$userId]],
        ]);

        return $channels;
    }

    public function getChannelsById($id)
    {
        $channels = $this->client->queryChannels([
            'id' => $id,
        ]);

        return $channels;
    }

    public function createChannel($channeltype = 'messaging', $members, $name = 'General')
    {
        $addChannelPrefix = '-04-';
        if ($channeltype === 'messaging') {
            if (count($members) > 2) {
                throw new \Exception('Messaging channel can only have 2 members');
            }
            $channelId = $members[0] . $addChannelPrefix . $members[1];
        } else {
            $channelId = uniqid($channeltype . '-' . $members[0]);
        }
        $exists = $this->client->queryChannels([
            'id' => $channelId,
        ]); 
        if (count($exists['channels']) > 0) {
            $channel = $this->client->channel($channeltype, $channelId);
            $channel->addMembers([strval(Auth::user()->id_user)]);
        } else {
            if ($channeltype === 'messaging') {
                $exists = $this->client->queryChannels([
                    'id' => $members[1] . $addChannelPrefix . $members[0],
                ]);
             
                if (count($exists['channels']) > 0) {
                    $channelId = $members[1] . $addChannelPrefix . $members[0];
                    $channel = $this->client->channel($channeltype, $channelId);
                    if (count($exists['channels'][0]['members']) < 2) {
                        $channel->addMembers([$members[0]]);
                    }
                } else {
                    $data = [
                        'name' => $name,
                        'members' => $members,
                    ];
                    $channel = $this->client->channel($channeltype, $channelId, $data);
                    $channel->create($members[0]);
                }
            } else {
                $data = [
                    'name' => $name,
                    'members' => $members,
                ];
                $channel = $this->client->channel($channeltype, $channelId, $data);
                $channel->create($members[0]);
            }
        }

        return $channel;
    }
}
