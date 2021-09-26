<?php

namespace App\Http\Requests\Resource;

use Illuminate\Foundation\Http\FormRequest;

class PdfResourceRequest extends FormRequest
{
    private $fieldsPrefix = '';

    public function __construct($fieldsPrefix = null)
    {
        if($fieldsPrefix){
            $this->fieldsPrefix = $fieldsPrefix;
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        if($this->getMethod() == 'POST' || $this->hasFile($this->prepareKey('fileRaw')))
        {
            $rules[$this->prepareKey('fileRaw')] = 'required|file|mimes:pdf|max:10240';
        }

        return $rules;
    }

    private function prepareKey($origKey)
    {
        if($this->fieldsPrefix)
        {
            return $this->fieldsPrefix.'.'.$origKey;
        }
        else
        {
            return $origKey;
        }
    }

    public function attributes()
    {
        return [
            $this->prepareKey('fileRaw') => 'PDF File',
        ];
    }
}
