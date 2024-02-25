<?php

namespace App\Services;

use Aws\Textract\TextractClient;

class TextractOcrService
{
    private function process($file) : string
    {
        $resultExtract = '';
        $textractClient = new TextractClient([
            'version' => 'latest',
            'region' => config('services.aws.region'),
            'credentials' => [
                'key'    => config('services.aws.key'),
                'secret' => config('services.aws.secret')
            ]
        ]);
        $result = $textractClient->detectDocumentText([
            'Document' => [
                'Bytes' => file_get_contents(storage_path('app/'.$file)),
            ],
            'FeatureTypes' => ['FORMS', 'TABLES']
        ]);
        foreach ($result->get('Blocks') as $block) {
            if ($block['BlockType'] === 'LINE'){
                $resultExtract.=$block['Text'].' ';
            }
        }
        return $resultExtract;
    }

    public function getDetail($file) : array
    {
        try{
            $block = $this->process($file);

            $nama = '';
            $nik = '';
            $tglLahir = '';
            $alamat = '';
            $agama = '';
            $status = '';
            $pekerjaan = '';
            $kewarganegaraan = '';
            if(preg_match('/[0-9].{15}/', $block, $match)) {
                $nik = $match[0];
            }

            if(preg_match('/Nama(.+?)Tempat/', $block, $match)) {
                $nama = trim($match[1]);
            }elseif (preg_match('/Nama(.+?)empat/', $block, $match)){
                $nama = trim($match[1]);
            }

            if(preg_match('/Lahir\s*:\s*(\S+\s\S+)/', $block, $match)) {
                $tglLahir = trim($match[1]);
            }

            if(preg_match('/Alamat(.+?)Agama/', $block, $match)) {
                $alamat = trim($match[1]);
            }elseif(preg_match('/lamat(.+?)gama/', $block, $match)){
                $alamat = trim($match[1]);
            }

            if(preg_match('/Agama : (\S+)/', $block, $match)) {
                $agama = trim($match[1]);
            }elseif(preg_match('/gama : (\S+)/', $block, $match)){
                $agama = trim($match[1]);
            }

            if(preg_match('/Status Perkawinan(.+?)Pekerjaan/', $block, $match)) {
                if(str_contains($match[0], 'KAWIN')){
                    $status = 'KAWIN';
                }
                if(str_contains($match[0], 'BELUM KAWIN')){
                    $status = 'BELUM KAWIN';
                }
            }elseif(preg_match('/tatus Perkawinan(.+?)ekerjaan/', $block, $match)){
                if(str_contains($match[0], 'KAWIN')){
                    $status = 'KAWIN';
                }
                if(str_contains($match[0], 'BELUM KAWIN')){
                    $status = 'BELUM KAWIN';
                }
            }


            if(preg_match('/Pekerjaan(.+?)Kewarganegaraan/', $block, $match)) {
                $pekerjaan = trim($match[1]);
            }elseif(preg_match('/ekerjaan(.+?)ewarganegaraan/', $block, $match)){
                $pekerjaan = trim($match[1]);
            }

            if(preg_match('/ewarganegaraan : (\S+)/', $block, $match)){
                $kewarganegaraan = trim($match[1]);
            }elseif (preg_match('/ewarganegaraan: (\S+)/', $block, $match)){
                $kewarganegaraan = trim($match[1]);
            }elseif(preg_match('/Kewarganegaraan(.+?)Berlaku/', $block, $match)) {
                $kewarganegaraan = trim($match[1]);
            }elseif(preg_match('/ewarganegaraan(.+?)erlaku/', $block, $match)){
                $kewarganegaraan = trim($match[1]);
            }

            return [
                'data' => [
                            'nama' => str_replace(':', '',$nama),
                            'nik' => $nik,
                            'tgl_lahir' => $tglLahir,
                            'alamat' => str_replace(':', '',$alamat),
                            'agama' => $agama,
                            'status' => $status,
                            'pekerjaan' => str_replace(':', '',$pekerjaan),
                            'kewarganegaraan' => str_replace(':', '',$kewarganegaraan),
                        ],
                'status' => 'success'
            ];
        }catch(\Exception $e){
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
