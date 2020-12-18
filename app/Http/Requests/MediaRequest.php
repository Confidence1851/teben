<?php

namespace App\Http\Requests;

use App\Helpers\AppConstants;
use Illuminate\Foundation\Http\FormRequest;

class MediaRequest extends FormRequest
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
        $request = request();
        if(optional(auth()->user())->role == AppConstants::ADMIN_USER_TYPE){
            $priceRule = "required";
        }
        else{
            $priceRule = "nullable";
        }
        return [
            'id' => 'nullable|string',
            'title' => 'required|string',
            'level' => 'required|string',
            'klass_id' => 'required|string',
            'subject_id' => 'required|string',
            'image' => 'required_if:id,null|image',
            'price' => $priceRule.'|string',
            'attachment' => 'required_if:id,null|'.$this->valid_attachment(),
            'status' => 'required|string',
            'term' => 'required|string',
        ];
        
    }

    
    public function valid_attachment()
    {
        return "mimetypes:".videoMimes().','.docMimes();
    }

}
