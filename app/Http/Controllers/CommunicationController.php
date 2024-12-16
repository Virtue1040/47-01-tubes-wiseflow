<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use GetStream\StreamChat\Client as StreamClient;
use App\Services\StreamChatService;
use Illuminate\Support\Facades\Auth;

class CommunicationController extends Controller
{
    protected $streamChatService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(StreamChatService $streamChatService)
    {
        $this->streamChatService = $streamChatService;
    }

    public function index() {
        $userId = Auth::user()->id_user; 
        $token = $this->streamChatService->createToken($userId);
        // $getUser = User::all();
        // $getUsers = [];
        // foreach ($getUser as $key => $value) {
        //     $getUsers[] = [
        //         'id_user' => $value->id_user,
        //         'full_name' => $value->contactInformation->first_name . ' ' . $value->contactInformation->last_name,
        //         'email' => $value->email,
        //     ];
        // }

        return view('view.chat', ['userToken' => $token]);
    }


    public function createUser(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'name' => 'required|string',
        ]);

        $user = $this->streamChatService->createUser($request->id, $request->name);
        return response()->json($user);
    }

    public function generateToken(Request $request)
    {
        $request->validate(['id' => 'required|string']);

        $token = $this->streamChatService->createToken($request->id);
        return response()->json(['token' => $token]);
    }
    
    public function getFullName(Request $request) {
        $request->validate([
            'id' => 'required|integer|exists:users,id_user',
        ]);
        $user = User::find($request->id);
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data Full Name',
            'data' => $user->contactInformation->first_name . ' ' . $user->contactInformation->last_name,
        ]);
    }

    public function getProfile(Request $request) {
        $request->validate([
            'id' => 'required|integer|exists:users,id_user',
        ]);
        $user = User::find($request->id);
        $data = [
            'full_name' => $user->contactInformation->first_name . ' ' . $user->contactInformation->last_name,
            'email' => $user->email,
            'gender' => $user->contactInformation->gender,
            'phone_number' => $user->contactInformation->no_hp,
            'imagePath' => $user->contactInformation->profilePath ? $user->contactInformation->profilePath : $user->social_avatar,
        ];
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data Profile',
            'data' => $data,
        ]);
    }

    public function createChannelPrivate(Request $request)
    {
        $request->validate([
            'id_user' => 'required|integer|exists:users,id_user',
        ]);
        
        $channel = $this->streamChatService->createChannel(
            'messaging',
            [strval(Auth::user()->id_user), strval($request->id_user)],
            $request->input('name', 'General')
        );

        return response()->json([
            'success' => true,
            'message' => 'Berhasil membuat channel private',
            'data' => $channel,
        ]);
    }

    public function resetChannel() {
        $client = $this->streamChatService->client;
        $channels = $client->queryChannels(['type' => ['$exists' => true]]);
        foreach ($channels['channels'] as $channel) {
            $channel = $client->Channel($channel['channel']['type'], $channel['channel']['id']);
            $channel->delete();
        }
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mereset channel',
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'channel_type' => 'required|string',
            'id_channel' => 'required|string',
            'message' => 'required|string|max:255',
        ]);

        $channel = $this->streamChatService->client->channel($request->channel_type, $request->id_channel);
        $message = $channel->sendMessage([
            'text' => $request->message,
        ], Auth::user()->id_user);
        $getChannel = $this->streamChatService->getChannelsById($request->id_channel);

        $channel->addMembers($getChannel['channels'][0]['channel']['original_members']);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengirim pesan',
            'data' => $message,
        ]);
    }

    public function getImage(Request $request) {
        $user = User::find($request->id);
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data Image',
            'data' => $user->contactInformation->profilePath ? $user->contactInformation->profilePath : $user->social_avatar,
        ]);
    }

    public function getUserChannel(Request $request)
    {
        $request->validate(['id' => 'required|string']);

        $channels = $this->streamChatService->getUserChannels($request->id);
        return response()->json($channels);
    }
}
