<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Kolom :attribute harus diterima.',
    'accepted_if' => 'Kolom :attribute harus diterima bila :other adalah :value.',
    'active_url' => 'Kolom :attribute bukan URL yang valid.',
    'after' => 'Kolom :attribute harus tanggal setelah :date.',
    'after_or_equal' => 'Kolom :attribute harus tanggal setelah atau sama dengan :date.',
    'alpha' => 'Kolom :attribute hanya boleh berisi huruf.',
    'alpha_dash' => 'Kolom :attribute hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
    'alpha_num' => 'Kolom :attribute hanya boleh berisi huruf dan angka.',
    'array' => 'Kolom :attribute harus berupa jajaran',
    'before' => 'Kolom :attribute harus tanggal sebelum :date.',
    'before_or_equal' => 'Kolom :attribute harus tanggal sebelum atau sama dengan :date.',
    'between' => [
        'numeric' => 'Kolom :attribute harus diantara :min dan :max.',
        'file' => 'Kolom :attribute harus diantara :min dan :max kilobyte.',
        'string' => 'Kolom :attribute harus diantara :min dan :max karakter.',
        'array' => 'Kolom :attribute harus memiliki antara :min dan :max item.',
    ],
    'boolean' => 'Kolom :attribute harus benar atau salah.',
    'confirmed' => 'Kolom :attribute konfirmasi tidak cocok.',
    'current_password' => 'Kolom password salah.',
    'date' => 'Kolom :attribute bukan tanggal yang valid.',
    'date_equals' => 'Kolom :attribute harus tanggal yang sama dengan:date.',
    'date_format' => 'Kolom :attribute tidak sesuai dengan format :format.',
    'different' => 'Kolom :attribute dan :other harus berbeda.',
    'digits' => 'Kolom :attribute harus :digits angka.',
    'digits_between' => 'Kolom :attribute harus diantara :min dan :max angka.',
    'dimensions' => 'Kolom :attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => 'Kolom :attribute memiliki nilai duplikat.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'ends_with' => 'Kolom :attribute harus diakhiri dengan salah satu dari berikut ini: :values.',
    'exists' => 'Kolom :attribute yg terpilih tidak benar.',
    'file' => 'Kolom :attribute harus berupa file.',
    'filled' => 'Kolom :attribute harus memiliki nilai.',
    'gt' => [
        'numeric' => 'Kolom :attribute harus lebih besar dari :value.',
        'file' => 'Kolom :attribute harus lebih besar dari :value kilobyte.',
        'string' => 'Kolom :attribute harus lebih besar dari :value karakter.',
        'array' => 'Kolom :attribute harus memiliki lebih dari :value item.',
    ],
    'gte' => [
        'numeric' => 'Kolom :attribute harus lebih besar dari atau sama dengan :value.',
        'file' => 'Kolom :attribute harus lebih besar dari atau sama dengan :value kilobyte.',
        'string' => 'Kolom :attribute harus lebih besar dari atau sama dengan :value karakter.',
        'array' => 'Kolom :attribute harus :value item atau lebih.',
    ],
    'image' => 'Kolom :attribute harus berupa gambar.',
    'in' => 'Kolom :attribute yang terpilih tidak valid.',
    'in_array' => 'Kolom :attribute tidak ada di :other.',
    'integer' => 'Kolom :attribute harus bilangan bulat.',
    'ip' => 'Kolom :attribute harus berupa alamat IP yang valid.',
    'ipv4' => 'Kolom :attribute harus alamat IPv4 yang valid.',
    'ipv6' => 'Kolom :attribute harus alamat IPv6 yang valid.',
    'json' => 'Kolom :attribute harus berupa string JSON yang valid.',
    'lt' => [
        'numeric' => 'Kolom :attribute harus kurang dari :value.',
        'file' => 'Kolom :attribute harus kurang dari :value kilobyte.',
        'string' => 'Kolom :attribute harus kurang dari :value karakter.',
        'array' => 'Kolom :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'Kolom :attribute harus kurang dari atau sama dengan :value.',
        'file' => 'Kolom :attribute harus kurang dari atau sama dengan :value kilobyte.',
        'string' => 'Kolom :attribute harus kurang dari atau sama dengan :value karakter.',
        'array' => 'Kolom :attribute tidak boleh lebih dari :value item.',
    ],
    'max' => [
        'numeric' => 'Kolom :attribute must not be greater than :max.',
        'file' => 'Kolom :attribute must not be greater than :max kilobyte.',
        'string' => 'Kolom :attribute must not be greater than :max karakter.',
        'array' => 'Kolom :attribute tidak boleh lebih dari :max item.',
    ],
    'mimes' => 'Kolom :attribute harus file bertipe: :values.',
    'mimetypes' => 'Kolom :attribute harus file bertipe: :values.',
    'min' => [
        'numeric' => 'Kolom :attribute harus memiliki setidaknya :min.',
        'file' => 'Kolom :attribute harus memiliki setidaknya :min kilobyte.',
        'string' => 'Kolom :attribute harus memiliki setidaknya :min karakter.',
        'array' => 'Kolom :attribute harus memiliki setidaknya :min item.',
    ],
    'multiple_of' => 'Kolom :attribute harus beberapa dari :value.',
    'not_in' => 'yang dipilih :attribute tidak valid.',
    'not_regex' => 'Kolom :attribute formatnya tidak valid.',
    'numeric' => 'Kolom :attribute harus berupa angka.',
    'password' => 'Kata sandi salah.',
    'present' => 'Kolom :attribute harus ada.',
    'regex' => 'Kolom :attribute formatnya tidak valid.',
    'required' => 'Kolom :attribute wajib diisi.',
    'required_if' => 'Kolom :attribute diperlukan ketika :other adalah :value.',
    'required_unless' => 'Kolom :attribute diperlukan kecuali :other ada didalam :values.',
    'required_with' => 'Kolom :attribute diperlukan ketika :values yang ada.',
    'required_with_all' => 'Kolom :attribute diperlukan ketika :values yang ada.',
    'required_without' => 'Kolom :attribute diperlukan ketika :values yang tidak ada.',
    'required_without_all' => 'Kolom :attribute wajib diisi jika tidak ada :values yang ada',
    'prohibited' => 'Kolom :attribute dilarang.',
    'prohibited_if' => 'Kolom :attribute dilarang ketika :other adalah :value.',
    'prohibited_unless' => 'Kolom :attribute dilarang kecuali :other ada didalam :values.',
    'same' => 'Kolom :attribute dan :other harus sama.',
    'size' => [
        'numeric' => 'Kolom :attribute harus :size.',
        'file' => 'Kolom :attribute harus :size kilobyte.',
        'string' => 'Kolom :attribute harus :size karakter.',
        'array' => 'Kolom :attribute harus mengandung :size item.',
    ],
    'starts_with' => 'Kolom :attribute harus dimulai dengan salah satu dari berikut ini: :values.',
    'string' => 'Kolom :attribute harus berupa string.',
    'timezone' => 'Kolom :attribute harus berupa zona waktu yang valid.',
    'unique' => 'Kolom :attribute sudah diambil.',
    'uploaded' => 'Kolom :attribute gagal mengunggah.',
    'url' => 'Kolom :attribute harus berupa URL yang valid.',
    'uuid' => 'Kolom :attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    // 'custom' => [
    //     'attribute-name' => [
    //         'rule-name' => 'custom-message',
    //     ],
    // ],
    'custom' => [
        'email' => [
            'required' => 'Kami perlu tahu alamat email Anda!',
            'email' => 'Email harus berupa alamat email yang valid.',
            'max' => 'Alamat email Anda terlalu panjang!'
        ],
        'password' => [
            'required' => 'Kami perlu tahu kata sandi Anda!',
            'min' => 'Kata sandi harus minimal 8 karakter.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'fullname' => 'Nama Lengkap',
        'phone' => 'No Telpon / No HP',
        'address' => 'Alamat',
    ],

];
