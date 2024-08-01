<?php

namespace App\Console\Commands;

use App\Models\Error;
use App\Models\ErrorCategory;
use App\Models\ErrorItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Collection;

class UpdateError extends Command
{
	protected $signature = 'update:error';
	protected $description = 'update database errors';
	private string $baseUrl , $token;
    private string $serverToken;

    public function __construct()
	{
		parent::__construct();
//		$this->baseUrl = 'https://api.farafix.com/api';
        $this->baseUrl = 'http://127.0.0.1:8000/api';
        $this->token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiODM3OGI5YWRjYzNkM2FhMjNiYTg0YjgwMjk3YTdmZTc2YTM1MzI2MDRlYTQ3MjMxNDczY2VmYjRlNGI5M2M2MTZhYWM2NjZlZDgxMGU1MDUiLCJpYXQiOjE3MTIyMjU5MzIuMjA3ODg3LCJuYmYiOjE3MTIyMjU5MzIuMjA3ODg5LCJleHAiOjE3NDM3NjE5MzEuOTkwOTE2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.GzJA_Dd-2Mi7f45_3xy-6-T0k8B9Hqanrc8ME2KkttzlwLyDw069YjNQV8lMs5id2rJIVnh-gF2hdNClcZcM4ie0hEB3mV-GS7lDFbSIHzk9WLsb9BMP70vCkuJOCkOu4a2EZ7HuskZ2Cb01BB_dPRYlEBAozjwliQA1SnWJsL_aTXqFcoehEgWJQolzgQiQcHB7arR70QBqarz7jrm5ShdXCNTtIfzFGYrPvkBMlG8XhRxwDshVz-v9-HTkmowm4NsKIVt0KfXLJo5znY6cOkkIKI-a-u8RTEs0amVR1rwHs27_85aIwl2E9RkQc3Nr4M47X4RR6UKOiH20QxcRuH14UrguI-TIG9_YeKt_scdwcPgn0v8VF1hMkcfZFyO3wSSHxrMYVRKNHVG5rD9Kfzbxevz01FMEk8Sj96ZEm54pWrKPLUvahwHCD5LEoelGbcmWghTKmtVHMFWvBnMm2LqQZpbW80UhhS8v2eeUp-k6S1ujVSReoBMwh9lL_EY2EXOclZZ2vA8ge5BwWcIeX_Y8P9EcQsSgxOdUUBLgnXo0Ju-KLsjMNuU3eVBo2W-7Q4KAIr5BQsbyQXr0b9oHvRlzO33t8wP1ghzYnorYraDryIV19hqxIDlElH63V1eA9vaNkpeM1kqJGgYqAtyuXahIBTEAe7T0H6r5aI7Z7rM';
		$this->serverToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMmMxNGRhNDkyZTJkOTNmMTdlNjJlNDZkNmEyMTgwYWIzNWYyY2MyNWRkNzlmYWJlNDc0ZDM3N2Q0NzY2ZWY4ZmFiNDY4MDRmYjExYzgyY2EiLCJpYXQiOjE3MDY0NDkwNDcuNjA1MiwibmJmIjoxNzA2NDQ5MDQ3LjYwNTIwMiwiZXhwIjoxNzM4MDcxNDQ3LjU4NzQ1Niwic3ViIjoiMzEiLCJzY29wZXMiOltdfQ.hiLqqmuVgbfzd6oyUdBTrol_ZqpD87Ww8xZgZqJUqVewDuvYa3gp_H2b5ijhdPvDhpHzyc2bLHLOrcqe04W9-SwM0CwZjjrA6PM-bI6_ReWfDCOfpGaZ-sh0VW3xOT393e7naYwh-HVjvS80ZebHZP29YHNpbxETb-s9zJUF8p_jWLei6prkZIxIuqh9_0T27O8agdUTpEshIJ5CpF_8I9zzv-ugX5pzuqD1iBTfD92XE3OSg2hkh6EWn7mEhFjnHZTxEGpqfPopIERqZs648Kg7VTw_edorD3gCfYxAKZc56FLtqGhH4z8vWm6md89XeEPpi8YbOUtCpRHcpRtejDJnE6rrS6w5j4jtlTxpdkW7WdY9FH0hj5gIr18cInZkcrqTg38ejnuJ49_Yy8FgRAjJR4SS3kxJbqqfVdaiBo-92CtWaOq8S7lO7vclznLQT3l8A0UjQT2gsUpqQePHVAwhpsDUvpOuGDR2TIL980Ijl1Mt2tI46eD_hTQMgAYv8hlssZ-LKruiq3nrVgHB33UsrBm7W5TB_ABLlu4ei98a4BWnb-66JTWJcBD34Ob960dNpUmj_jGW1fwVLZKo-cevGCjYoRAykfYLXEEHxHSYADyFtKvpF-nCiwlio0HqQUS1vXcAtIANzYO6vWefSmEwrJcnvI3UOkOCG4Pwrh8';
	}

	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		$errorCategories = ErrorCategory::all();
		foreach ( $errorCategories as $errorCategory ) {
			$response = Http::accept( 'application/json' )->withToken( $this->token )->post( $this->baseUrl . '/error-categories' , [
				"title" => $errorCategory->title ,
				"title_en" => $errorCategory->title_en ,
				"name" => $errorCategory->name ,
				"date" => $errorCategory->data ,
				"description" => $errorCategory->description
			] );
			if ( $response->ok() ) {
				$this->storeError();
			}
		}
	}

	public function storeError(): void
    {
		$errors = Error::all();
		foreach ( $errors as $error ) {
			$response = Http::accept( 'application/json' )->withToken( $this->token )->post( $this->baseUrl . '/errors' , [
				"title" => $error->title ,
				"title_en" => $error->title_en ,
				"summary" => $error->name ,
				"category_id" => $error->category_id ,
				"description" => $error->description ,
				"items" => $this->getErrorItems( $error->id ) ?? []
			] );
			dd( $response->json() );
		}
	}

	public function getErrorItems( $errorId ): Collection|array
	{
		return ErrorItem::query()->where( 'error_id' , $errorId )->get();
	}
}
