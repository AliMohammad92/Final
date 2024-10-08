<?php

namespace App\Http\Requests;

use App\Traits\responseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class OpportunityRequest extends FormRequest
{
    use responseTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'body' => 'required',
            'job_type' => 'required|in:full_time,part_time,contract,temporary,volunteer',
            'work_place_type' => 'required|in:on_site,hybrid,remote',
            'job_hours' => 'required',
            'skills_req' => 'required',
            'salary' => 'required',
            'vacant' => 'required',
            'images.*'=>'image|mimes:jpeg,png,jpg,gif|max:100000',
            'files.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,sql,php,jsx,js,html,css,dart,cpp,py'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            $this->apiResponse(null, $errors, JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
