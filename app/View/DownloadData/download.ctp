<?php
$this->Csv->clear();
if(count($fieldNameArray)>0)
    {
        $this->Csv->addRow($fieldNameArray);
        foreach($readings as $reading) {
        for($i=0;$i<count($fieldNameArray);$i++)
        $this->Csv->addField($reading['WorkOrder'][$fieldNameArray[$i]]);
        $this->Csv->endRow();

        }
$this->Csv->setFilename('export.csv');
//set formats if needed echo $this->Csv->render(true, 'sjis', 'utf-8');
echo $this->Csv->render();
}

?>