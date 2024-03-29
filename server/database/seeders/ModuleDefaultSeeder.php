<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleDefaultSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('module_defaults')->insert([
            ["id"=>1, "config_structure"=>'{"form_fields":{"field":2,"label":null,"inputType":"number","fieldType":"text","displayField":true,"hiddenField":false,"inputParameters":null,"inputParametersPreview":[],"inputParametersDefault":null,"icon":{"color":"#6453DCED","name":"mdi-folder"},"textareaRows":3,"responsiveGrid":6,"inputPlaceholder":null,"inputHint":null,"validation":{"rulesString":null,"rulesArray":[],"range":{"active":false,"min":0,"max":0},"minValue":{"active":false,"value":0},"maxValue":{"active":false,"value":0},"length":{"active":false,"value":0},"maxLength":{"active":false,"value":0},"minLength":{"active":false,"value":0},"digits":{"active":false,"value":0},"regex":{"active":false,"value":null},"unique":false},"events":{"eventInput":null,"eventChange":null,"eventBlur":null,"eventFocus":null},"slots":{"prepend":{"active":false,"function":null,"button":null,"buttonColor":null,"icon":null,"iconColor":null,"whiteText":false}},"parentMenu":0,"datePickerTrigger":false,"dropdownText":"text","dropdownValue":"value","options":{"fieldBackgroundColor":null,"fieldColor":"teal","tooltip":null,"returnObject":{"conditioned":false,"conditionFunction":null,"value":false},"disabled":{"conditioned":false,"conditionFunction":null,"value":false},"clearable":{"conditioned":false,"conditionFunction":null,"value":false},"multiple":{"conditioned":false,"conditionFunction":null,"value":false},"hideDetails":{"conditioned":false,"conditionFunction":null,"value":false},"dark":{"conditioned":false,"conditionFunction":null,"value":false},"noResize":{"conditioned":false,"conditionFunction":null,"value":false},"dense":{"conditioned":false,"conditionFunction":null,"value":false},"counter":{"conditioned":false,"conditionFunction":null,"value":false},"field":null,"display_field":true}},"columns":{"value":null,"text":null},"general_config":{"sql_query":null,"sql_table":null,"sql_select":null,"note":null,"isVisibleInSidebar":false,"title":null}}']
        ]);
    }
}
