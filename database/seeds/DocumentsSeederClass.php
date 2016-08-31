<?php

use App\Models\Documents\DocumentGroup;
use App\Models\Documents\Document;
use App\Models\Documents\DocumentAttributes;
use App\Models\Documents\DocumentFile;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Excel;

class DocumentsSeederClass extends Seeder {

    public function run() {

        try {

//            \DB::beginTransaction();
            \DB::table('documents')->truncate();
            \DB::table('documents_groups')->truncate();
            \DB::table('documents_attributes')->truncate();
            \DB::table('documents_files')->truncate();

            echo "[START SCRIPT] \n";
            $filePath = storage_path('import') . '/waren.xlsx';
            for ($i = 0; $i < 9; $i++) {
                $results = \Excel::selectSheetsByIndex(1)->load($filePath)->get();

                $docGroupId = null;

                $groupsLevels = [
                    'level1' => null,
                    'level2' => null,
                    'level3' => null
                ];
                foreach ($results as $index => $row) {

                    if (empty($row->name)) {
                        continue;
                    }
                    if ($row->name == 'Bezeichnung') {
                        continue;
                    }

                    if (substr($row->name, 0, 9) == 'WG Ebene ') {
                        $level = (int) substr($row->name, 9, 1);
                        switch ($level) {
                            case 1:
                                $idParent = null;
                                break;
                            case 2:
                                $idParent = $groupsLevels['level1']->id;
                                break;
                            case 3:
                                $idParent = $groupsLevels['level2']->id;
                                break;
                        }
                        // trzeba sprawdzić czy są duplikaty 
                        // zmień grupę na której operujemy
                        $parseInt = (int) $row->number;
                        $maskNum = substr('00' . $parseInt, -2);

                        $documentGroup = DocumentGroup::create([
                                    'id_parent' => $idParent,
                                    'name' => $row->name,
                                    'description' => $row->description,
                                    'number' => $maskNum
                        ]);
                        echo $maskNum;
                        echo "\nAdd group do Database\n";
                        echo "Group name: " . $row->name . ' ' . $maskNum . '  ' . $row->description . "\n\n";


                        switch ($level) {
                            case 1:
                                $groupsLevels['level1'] = $documentGroup;
                                $groupsLevels['level2'] = null;
                                $groupsLevels['level3'] = null;
                                break;
                            case 2:
                                $groupsLevels['level2'] = $documentGroup;
                                $groupsLevels['level3'] = null;
                                break;
                            case 3:
                                $groupsLevels['level3'] = $documentGroup;
                                break;
                        }
                        //$docGroupId++

                        continue;
                    }


                    $document = Document::create([
                                'name' => $row->name,
                                'documents_groups__id' => $documentGroup->id,
                                'description' => (!empty($row->description)) ? $row->description : '',
                                'type' => (!empty($row->type)) ? $row->type : '',
                                    // 'order_number' => $maskNum,
                                    // 'user__id' => 0
                    ]);
                    echo "\nAdd document do Database for selected group\n";
                    echo $index . '|' . $row->name . ' ' . $row->description . ' ' . $row->type . "\n";

                    $document2 = DocumentFile::create([

                                'name' => $row->name,
                                'documents__id' => $document->id,
                                'fullname' => '[' . $row->name . ']' . '.pdf',
                                'extension' => 'pdf',
                                'hash' => hash('md5', $row->name . date('Y-m-d H:i:s:u'))
                    ]);
                    $params = [
                        'A' => $row->a,
                        'B' => $row->b,
                        'C' => $row->c,
                        'F' => $row->f,
                        'TEST' => $row->test,
                    ];

                    foreach ($params as $key => $param) {
                        if (empty($param)) {
                            continue;
                        }
                        $documentAttribute = DocumentAttributes::create([
                                    // id dokumentu
                                    'documents__id' => $document->id,
                                    'name' => $key,
                                    'type' => 'BOOL',
                                    'value' => $param
                        ]);
                    }

//                \DB::commit();
                }
            }
            echo "\n[FINISH SCRIPT]\n";
        } catch (\Exception $ex) {
            echo $ex->getMessage() . $ex->getLine();
//            \DB::rollback();
        }
    }

}
