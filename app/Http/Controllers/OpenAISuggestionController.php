<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OpenAISuggestionController extends Controller
{
    public function suggestBlabs(Request $request) {
      
      // Logic
      // validation
      $request->validate([
        'blab'=>'required|string|max:255'
      ]);

      // prendere la openAI api key dall'.env
      $apiKey = env('OPENAI_API_KEY');

      // prendiamo il testo digitato dall'utente nella textarea
      $userInput = $request->input('blab');

      // chiamata a openAI
      $url = 'https://api.openai.com/v1/chat/completions';
      $payload = [
        'model'   => 'GPT-4o-mini',
        // invio di messaggi a chatGPT
        'messages'=> [
          ['role'=>'system', 'content'=>'You are an assistant who suggests improvements to blabs.'],
          ['role'=>'user', 'content'=>$userInput]
        ],
        'temperature' => 0.7
      ];

      // inizializziamo curl
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-type: application/json",
        "Authorization: Bearer $apiKey",
      ]);
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

      $response = curl_exec($ch);

      if(curl_errno($ch)) {
        return response()->json(['error' => 'Request error: ' . curl_error($ch) ], 500);
      }
      
      // chiudo la connessione
      curl_close($ch);

      // decodifico la risposta
      $respondeData = json_decode($response);

      if(isset($respondeData['error'])) {
        return response()->json(['error' => $respondeData['error']['message']], 500);
      }

      // se la risposta non ha consegnato errori possiamo restituire al js
      // che si occuperà di inserire il valore nella textarea e che verrà visualizzato dall'utente
      // il modello fornisce una array di risposte possibili
      // prendo la prima

      $suggestion = $resposeData['choices'][0]['message']['content'] ?? 'No suggestion available';
      return response()->json(['suggestion' => $suggestion], 200);

    }
}
