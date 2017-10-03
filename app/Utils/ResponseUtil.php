<?php namespace App\Utils;

class ResponseUtil
{
    /**
     * @param string $message
     * @param mixed $result
     * @param mixed $meta
     *
     * @return array
     */
    public static function makeResponse($message, $result, $meta = null)
    {
        //hack for removing 'data' from transformer response
        if ((is_array($result) && isset($result['data']))) {
            $data = $result['data'];
            $meta = isset($result['meta']) ? $result['meta'] : $meta;
        } else {
            $data = $result;
        }

        $response = [
            'success' => true,
            'data' => $data,
            'meta' => $meta,
            'message' => $message,
        ];

        return $response;
    }

    /**
     * @param string $message
     * @param array $data
     *
     * @return array
     */
    public static function makeError($message, array $data = [])
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }
}
