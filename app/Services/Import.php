<?php

namespace App\Services;

use App\Jobs\SaveShippingJob;

class Import
{
    public function csvFile($file, $headers, $database)
    {
        $database->delete();
        $uploadPath = $this->upload($file);
        $item =  $this->getCsvRow($uploadPath);

        foreach ($item as $data) {
            $this->parseData($data, $headers);
        }
        return [
            'status' => 201,
            'message' => 'Arquivos Importados com Sucesso!'
        ];
    }

    private function parseData(array $data, array $headers)
    {
        if ($data != $headers) {
            $entity = [];

            foreach ($data as $key => $value) {
                $entity[$headers[$key]] = preg_replace(
                    '/\,/',
                    '.',
                    preg_replace(
                        '/[.-]/',
                        '',
                        $value
                    )
                );
            }

            $this->saveData($entity);
        }
    }

    private function saveData($entity)
    {
        SaveShippingJob::dispatch($entity);
    }

    public function upload($file)
    {
        // Define o nome
        $nameFile = "{$file->getClientOriginalName()}";
        // Upload na pasta storage/app/public/import
        $upload = $file->storeAs('import', $nameFile);

        return $upload;
    }

    private function getCsvRow($file)
    {
        $fileCsv = fopen(storage_path("app/{$file}"), 'r');
        while ($data = fgetcsv($fileCsv, 0, ';')) {
            yield $data;
        }
    }
}
