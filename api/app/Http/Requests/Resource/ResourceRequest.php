<?php

namespace App\Http\Requests\Resource;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class ResourceRequest extends FormRequest
{
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
        $rules = [
            'title' => 'required'
        ];
        if($this->getMethod() == 'POST')
        {
            $rules['type'] = 'required';
        }
        return $rules;
    }

    public function passedValidation()
    {
        if($this->getMethod() == 'POST')
        {
            $type = $this->input('type');
        }
        else
        {
            $type = $this->route('resource')->type;
        }
        switch ($type) 
        {
            case 'pdf':
                App::makeWith(PdfResourceRequest::class, ['fieldsPrefix' => 'pdf']);
                break;
            case 'html':
                App::makeWith(HtmlResourceRequest::class, ['fieldsPrefix' => 'html']);
                break;
            case 'link':
                App::makeWith(LinkResourceRequest::class, ['fieldsPrefix' => 'link']);
                break;
            default:
                break;
        }
    }

    public function attributes()
    {
        return [
            'title' => 'Title',
            'type' => 'Resource Type',
        ];
    }
}
