<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponentDefaultSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('component_defaults')->insert([
            ["id"=>1, "config_structure"=>'{"form_fields":{"field":"","label":"","inputType":"text","fieldType":"text","displayField":true,"hiddenField":false,"inputParameters":"","inputParametersPreview":[],"inputParametersDefault":"","inputIcon":"","textareaRows":3,"responsiveGrid":6,"inputPlaceholder":"","inputHint":"","validation":{"rulesString":"","rulesArray":[],"range":{"active":false,"min":0,"max":0},"minValue":{"active":false,"value":0},"maxValue":{"active":false,"value":0},"length":{"active":false,"value":0},"maxLength":{"active":false,"value":0},"minLength":{"active":false,"value":0},"digits":{"active":false,"value":0},"regex":{"active":false,"value":""},"unique":false},"events":{"eventInput":"","eventChange":"","eventBlur":"","eventFocus":""},"slots":{"prepend":{"active":false,"function":"","button":"","buttonColor":"","icon":"","iconColor":"","whiteText":false}},"parentMenu":0,"datePickerTrigger":false,"dropdownText":"text","dropdownValue":"value","options":{"fieldBackgroundColor":"","fieldColor":"teal","tooltip":"","returnObject":{"conditioned":false,"conditionFunction":"","value":false},"disabled":{"conditioned":false,"conditionFunction":"","value":false},"clearable":{"conditioned":false,"conditionFunction":"","value":false},"multiple":{"conditioned":false,"conditionFunction":"","value":false},"hideDetails":{"conditioned":false,"conditionFunction":"","value":false},"dark":{"conditioned":false,"conditionFunction":"","value":false},"noResize":{"conditioned":false,"conditionFunction":"","value":false},"dense":{"conditioned":false,"conditionFunction":"","value":false},"counter":{"conditioned":false,"conditionFunction":"","value":false},"field":"","display_field":true}},"sql_table":"","sql_select":"","sql_where":"","sql_group":"","columns":[],"name":"","title":"","note":""}']
        ]);
    }
}
