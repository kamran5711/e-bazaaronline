<?php
namespace App\Traits;
trait SendResponseTrait {
    public function SendResponse($status, $message, $data = []) {
        if (empty($data)) {
            $data = new \stdClass();
        }
        $response = [
            'success' => $status,
            'message' => $message,
            'data' => $data
        ];
        return response()->json($response, 200);   
    }
}
?>