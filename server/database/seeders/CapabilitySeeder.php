<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CapabilitySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('capabilities')->insert([
            ["id"=>1, "name"=>"DocumentType.create"],
            ["id"=>2, "name"=>"DocumentType.read"],
            ["id"=>3, "name"=>"DocumentType.show"],
            ["id"=>4, "name"=>"DocumentType.showAll"],
            ["id"=>5, "name"=>"DocumentType.showTrashed"],
            ["id"=>6, "name"=>"DocumentType.recoveryTrashed"],
            ["id"=>7, "name"=>"DocumentType.update"],
            ["id"=>8, "name"=>"DocumentType.updateAll"],
            ["id"=>9, "name"=>"DocumentType.destroy"],
            ["id"=>10, "name"=>"DocumentType.forceDestroy"],
            ["id"=>11, "name"=>"DocumentType.attach"],

            ["id"=>12, "name"=>"PaymentMethod.create"],
            ["id"=>13, "name"=>"PaymentMethod.read"],
            ["id"=>14, "name"=>"PaymentMethod.show"],
            ["id"=>15, "name"=>"PaymentMethod.showAll"],
            ["id"=>16, "name"=>"PaymentMethod.showTrashed"],
            ["id"=>17, "name"=>"PaymentMethod.recoveryTrashed"],
            ["id"=>18, "name"=>"PaymentMethod.update"],
            ["id"=>19, "name"=>"PaymentMethod.updateAll"],
            ["id"=>20, "name"=>"PaymentMethod.destroy"],
            ["id"=>21, "name"=>"PaymentMethod.forceDestroy"],
            ["id"=>22, "name"=>"PaymentMethod.attach"],

            ["id"=>23, "name"=>"Brand.create"],
            ["id"=>24, "name"=>"Brand.read"],
            ["id"=>25, "name"=>"Brand.show"],
            ["id"=>26, "name"=>"Brand.showAll"],
            ["id"=>27, "name"=>"Brand.showTrashed"],
            ["id"=>28, "name"=>"Brand.recoveryTrashed"],
            ["id"=>29, "name"=>"Brand.update"],
            ["id"=>30, "name"=>"Brand.updateAll"],
            ["id"=>31, "name"=>"Brand.destroy"],
            ["id"=>32, "name"=>"Brand.forceDestroy"],
            ["id"=>33, "name"=>"Brand.attach"],

            ["id"=>34, "name"=>"Category.create"],
            ["id"=>35, "name"=>"Category.read"],
            ["id"=>36, "name"=>"Category.show"],
            ["id"=>37, "name"=>"Category.showAll"],
            ["id"=>38, "name"=>"Category.showTrashed"],
            ["id"=>39, "name"=>"Category.recoveryTrashed"],
            ["id"=>40, "name"=>"Category.update"],
            ["id"=>41, "name"=>"Category.updateAll"],
            ["id"=>42, "name"=>"Category.destroy"],
            ["id"=>43, "name"=>"Category.forceDestroy"],
            ["id"=>44, "name"=>"Category.attach"],

            ["id"=>45, "name"=>"Family.create"],
            ["id"=>46, "name"=>"Family.read"],
            ["id"=>47, "name"=>"Family.show"],
            ["id"=>48, "name"=>"Family.showAll"],
            ["id"=>49, "name"=>"Family.showTrashed"],
            ["id"=>50, "name"=>"Family.recoveryTrashed"],
            ["id"=>51, "name"=>"Family.update"],
            ["id"=>52, "name"=>"Family.updateAll"],
            ["id"=>53, "name"=>"Family.destroy"],
            ["id"=>54, "name"=>"Family.forceDestroy"],
            ["id"=>55, "name"=>"Family.attach"],

            ["id"=>56, "name"=>"MeasurementUnit.create"],
            ["id"=>57, "name"=>"MeasurementUnit.read"],
            ["id"=>58, "name"=>"MeasurementUnit.show"],
            ["id"=>59, "name"=>"MeasurementUnit.showAll"],
            ["id"=>60, "name"=>"MeasurementUnit.showTrashed"],
            ["id"=>61, "name"=>"MeasurementUnit.recoveryTrashed"],
            ["id"=>62, "name"=>"MeasurementUnit.update"],
            ["id"=>63, "name"=>"MeasurementUnit.updateAll"],
            ["id"=>64, "name"=>"MeasurementUnit.destroy"],
            ["id"=>65, "name"=>"MeasurementUnit.forceDestroy"],
            ["id"=>66, "name"=>"MeasurementUnit.attach"],

            ["id"=>67, "name"=>"MeasurementUnitSystem.create"],
            ["id"=>68, "name"=>"MeasurementUnitSystem.read"],
            ["id"=>69, "name"=>"MeasurementUnitSystem.show"],
            ["id"=>70, "name"=>"MeasurementUnitSystem.showAll"],
            ["id"=>71, "name"=>"MeasurementUnitSystem.showTrashed"],
            ["id"=>72, "name"=>"MeasurementUnitSystem.recoveryTrashed"],
            ["id"=>73, "name"=>"MeasurementUnitSystem.update"],
            ["id"=>74, "name"=>"MeasurementUnitSystem.updateAll"],
            ["id"=>75, "name"=>"MeasurementUnitSystem.destroy"],
            ["id"=>76, "name"=>"MeasurementUnitSystem.forceDestroy"],
            ["id"=>77, "name"=>"MeasurementUnitSystem.attach"],

            ["id"=>78, "name"=>"Mkup.create"],
            ["id"=>79, "name"=>"Mkup.read"],
            ["id"=>80, "name"=>"Mkup.show"],
            ["id"=>81, "name"=>"Mkup.showAll"],
            ["id"=>82, "name"=>"Mkup.showTrashed"],
            ["id"=>83, "name"=>"Mkup.recoveryTrashed"],
            ["id"=>84, "name"=>"Mkup.update"],
            ["id"=>85, "name"=>"Mkup.updateAll"],
            ["id"=>86, "name"=>"Mkup.destroy"],
            ["id"=>87, "name"=>"Mkup.forceDestroy"],
            ["id"=>88, "name"=>"Mkup.attach"],

            ["id"=>89, "name"=>"Price.create"],
            ["id"=>90, "name"=>"Price.read"],
            ["id"=>91, "name"=>"Price.show"],
            ["id"=>92, "name"=>"Price.showAll"],
            ["id"=>93, "name"=>"Price.showTrashed"],
            ["id"=>94, "name"=>"Price.recoveryTrashed"],
            ["id"=>95, "name"=>"Price.update"],
            ["id"=>96, "name"=>"Price.updateAll"],
            ["id"=>97, "name"=>"Price.destroy"],
            ["id"=>98, "name"=>"Price.forceDestroy"],
            ["id"=>99, "name"=>"Price.attach"],
            
            ["id"=>100, "name"=>"Product.create"],
            ["id"=>101, "name"=>"Product.read"],
            ["id"=>102, "name"=>"Product.show"],
            ["id"=>103, "name"=>"Product.showAll"],
            ["id"=>104, "name"=>"Product.showTrashed"],
            ["id"=>105, "name"=>"Product.recoveryTrashed"],
            ["id"=>106, "name"=>"Product.update"],
            ["id"=>107, "name"=>"Product.updateAll"],
            ["id"=>108, "name"=>"Product.destroy"],
            ["id"=>109, "name"=>"Product.forceDestroy"],
            ["id"=>110, "name"=>"Product.attach"],
            
            ["id"=>111, "name"=>"ProductPromotion.create"],
            ["id"=>112, "name"=>"ProductPromotion.read"],
            ["id"=>113, "name"=>"ProductPromotion.show"],
            ["id"=>114, "name"=>"ProductPromotion.showAll"],
            ["id"=>115, "name"=>"ProductPromotion.showTrashed"],
            ["id"=>116, "name"=>"ProductPromotion.recoveryTrashed"],
            ["id"=>117, "name"=>"ProductPromotion.update"],
            ["id"=>118, "name"=>"ProductPromotion.updateAll"],
            ["id"=>119, "name"=>"ProductPromotion.destroy"],
            ["id"=>120, "name"=>"ProductPromotion.forceDestroy"],
            ["id"=>121, "name"=>"ProductPromotion.attach"],
            
            ["id"=>122, "name"=>"AccountPayment.create"],
            ["id"=>123, "name"=>"AccountPayment.read"],
            ["id"=>124, "name"=>"AccountPayment.show"],
            ["id"=>125, "name"=>"AccountPayment.showAll"],
            ["id"=>126, "name"=>"AccountPayment.showTrashed"],
            ["id"=>127, "name"=>"AccountPayment.recoveryTrashed"],
            ["id"=>128, "name"=>"AccountPayment.update"],
            ["id"=>129, "name"=>"AccountPayment.updateAll"],
            ["id"=>130, "name"=>"AccountPayment.destroy"],
            ["id"=>131, "name"=>"AccountPayment.forceDestroy"],
            ["id"=>132, "name"=>"AccountPayment.attach"],

            ["id"=>133, "name"=>"AccountPlan.create"],
            ["id"=>134, "name"=>"AccountPlan.read"],
            ["id"=>135, "name"=>"AccountPlan.show"],
            ["id"=>136, "name"=>"AccountPlan.showAll"],
            ["id"=>137, "name"=>"AccountPlan.showTrashed"],
            ["id"=>138, "name"=>"AccountPlan.recoveryTrashed"],
            ["id"=>139, "name"=>"AccountPlan.update"],
            ["id"=>140, "name"=>"AccountPlan.updateAll"],
            ["id"=>141, "name"=>"AccountPlan.destroy"],
            ["id"=>142, "name"=>"AccountPlan.forceDestroy"],
            ["id"=>143, "name"=>"AccountPlan.attach"],

            ["id"=>144, "name"=>"Address.create"],
            ["id"=>145, "name"=>"Address.read"],
            ["id"=>146, "name"=>"Address.show"],
            ["id"=>147, "name"=>"Address.showAll"],
            ["id"=>148, "name"=>"Address.showTrashed"],
            ["id"=>149, "name"=>"Address.recoveryTrashed"],
            ["id"=>150, "name"=>"Address.update"],
            ["id"=>151, "name"=>"Address.updateAll"],
            ["id"=>152, "name"=>"Address.destroy"],
            ["id"=>153, "name"=>"Address.forceDestroy"],
            ["id"=>154, "name"=>"Address.attach"],
            
            ["id"=>155, "name"=>"Branch.create"],
            ["id"=>156, "name"=>"Branch.read"],
            ["id"=>157, "name"=>"Branch.show"],
            ["id"=>158, "name"=>"Branch.showAll"],
            ["id"=>159, "name"=>"Branch.showTrashed"],
            ["id"=>160, "name"=>"Branch.recoveryTrashed"],
            ["id"=>161, "name"=>"Branch.update"],
            ["id"=>162, "name"=>"Branch.updateAll"],
            ["id"=>163, "name"=>"Branch.destroy"],
            ["id"=>164, "name"=>"Branch.forceDestroy"],
            ["id"=>165, "name"=>"Branch.attach"],
            
            ["id"=>166, "name"=>"Entity.create"],
            ["id"=>167, "name"=>"Entity.read"],
            ["id"=>168, "name"=>"Entity.show"],
            ["id"=>169, "name"=>"Entity.showAll"],
            ["id"=>170, "name"=>"Entity.showTrashed"],
            ["id"=>171, "name"=>"Entity.recoveryTrashed"],
            ["id"=>172, "name"=>"Entity.update"],
            ["id"=>173, "name"=>"Entity.updateAll"],
            ["id"=>177, "name"=>"Entity.destroy"],
            ["id"=>178, "name"=>"Entity.forceDestroy"],
            ["id"=>179, "name"=>"Entity.attach"],

            ["id"=>180, "name"=>"Phone.create"],
            ["id"=>181, "name"=>"Phone.read"],
            ["id"=>182, "name"=>"Phone.show"],
            ["id"=>183, "name"=>"Phone.showAll"],
            ["id"=>184, "name"=>"Phone.showTrashed"],
            ["id"=>185, "name"=>"Phone.recoveryTrashed"],
            ["id"=>186, "name"=>"Phone.update"],
            ["id"=>187, "name"=>"Phone.updateAll"],
            ["id"=>188, "name"=>"Phone.destroy"],
            ["id"=>190, "name"=>"Phone.forceDestroy"],
            ["id"=>191, "name"=>"Phone.attach"],
            
            ["id"=>192, "name"=>"PoinOfSale.create"],
            ["id"=>193, "name"=>"PoinOfSale.read"],
            ["id"=>194, "name"=>"PoinOfSale.show"],
            ["id"=>195, "name"=>"PoinOfSale.showAll"],
            ["id"=>196, "name"=>"PoinOfSale.showTrashed"],
            ["id"=>197, "name"=>"PoinOfSale.recoveryTrashed"],
            ["id"=>198, "name"=>"PoinOfSale.update"],
            ["id"=>199, "name"=>"PoinOfSale.updateAll"],
            ["id"=>200, "name"=>"PoinOfSale.destroy"],
            ["id"=>201, "name"=>"PoinOfSale.forceDestroy"],
            ["id"=>202, "name"=>"PoinOfSale.attach"],

            ["id"=>203, "name"=>"RootAccount.create"],
            ["id"=>204, "name"=>"RootAccount.read"],
            ["id"=>205, "name"=>"RootAccount.show"],
            ["id"=>206, "name"=>"RootAccount.showAll"],
            ["id"=>207, "name"=>"RootAccount.showTrashed"],
            ["id"=>208, "name"=>"RootAccount.recoveryTrashed"],
            ["id"=>209, "name"=>"RootAccount.update"],
            ["id"=>210, "name"=>"RootAccount.updateAll"],
            ["id"=>211, "name"=>"RootAccount.destroy"],
            ["id"=>212, "name"=>"RootAccount.forceDestroy"],
            ["id"=>213, "name"=>"RootAccount.attach"],

            ["id"=>214, "name"=>"Social.create"],
            ["id"=>215, "name"=>"Social.read"],
            ["id"=>216, "name"=>"Social.show"],
            ["id"=>217, "name"=>"Social.showAll"],
            ["id"=>218, "name"=>"Social.showTrashed"],
            ["id"=>219, "name"=>"Social.recoveryTrashed"],
            ["id"=>220, "name"=>"Social.update"],
            ["id"=>221, "name"=>"Social.updateAll"],
            ["id"=>222, "name"=>"Social.destroy"],
            ["id"=>223, "name"=>"Social.forceDestroy"],
            ["id"=>224, "name"=>"Social.attach"],

            ["id"=>225, "name"=>"User.create"],
            ["id"=>226, "name"=>"User.read"],
            ["id"=>227, "name"=>"User.show"],
            ["id"=>228, "name"=>"User.showAll"],
            ["id"=>229, "name"=>"User.showTrashed"],
            ["id"=>230, "name"=>"User.recoveryTrashed"],
            ["id"=>231, "name"=>"User.update"],
            ["id"=>232, "name"=>"User.updateAll"],
            ["id"=>233, "name"=>"User.destroy"],
            ["id"=>234, "name"=>"User.forceDestroy"],
            ["id"=>235, "name"=>"User.attach"],

            ["id"=>236, "name"=>"UserSettings.create"],
            ["id"=>237, "name"=>"UserSettings.read"],
            ["id"=>238, "name"=>"UserSettings.show"],
            ["id"=>239, "name"=>"UserSettings.showAll"],
            ["id"=>240, "name"=>"UserSettings.showTrashed"],
            ["id"=>241, "name"=>"UserSettings.recoveryTrashed"],
            ["id"=>242, "name"=>"UserSettings.update"],
            ["id"=>243, "name"=>"UserSettings.updateAll"],
            ["id"=>244, "name"=>"UserSettings.destroy"],
            ["id"=>245, "name"=>"UserSettings.forceDestroy"],
            ["id"=>246, "name"=>"UserSettings.attach"],

            ["id"=>247, "name"=>"Country.create"],
            ["id"=>248, "name"=>"Country.read"],
            ["id"=>249, "name"=>"Country.show"],
            ["id"=>250, "name"=>"Country.showAll"],
            ["id"=>251, "name"=>"Country.showTrashed"],
            ["id"=>252, "name"=>"Country.recoveryTrashed"],
            ["id"=>253, "name"=>"Country.update"],
            ["id"=>254, "name"=>"Country.updateAll"],
            ["id"=>255, "name"=>"Country.destroy"],
            ["id"=>256, "name"=>"Country.forceDestroy"],
            ["id"=>257, "name"=>"Country.attach"],

            ["id"=>258, "name"=>"State.create"],
            ["id"=>259, "name"=>"State.read"],
            ["id"=>260, "name"=>"State.show"],
            ["id"=>261, "name"=>"State.showAll"],
            ["id"=>262, "name"=>"State.showTrashed"],
            ["id"=>263, "name"=>"State.recoveryTrashed"],
            ["id"=>264, "name"=>"State.update"],
            ["id"=>265, "name"=>"State.updateAll"],
            ["id"=>266, "name"=>"State.destroy"],
            ["id"=>267, "name"=>"State.forceDestroy"],
            ["id"=>268, "name"=>"State.attach"],

            ["id"=>269, "name"=>"Capability.create"],
            ["id"=>270, "name"=>"Capability.read"],
            ["id"=>271, "name"=>"Capability.show"],
            ["id"=>272, "name"=>"Capability.showAll"],
            ["id"=>273, "name"=>"Capability.showTrashed"],
            ["id"=>274, "name"=>"Capability.recoveryTrashed"],
            ["id"=>275, "name"=>"Capability.update"],
            ["id"=>276, "name"=>"Capability.updateAll"],
            ["id"=>277, "name"=>"Capability.destroy"],
            ["id"=>278, "name"=>"Capability.forceDestroy"],
            ["id"=>279, "name"=>"Capability.attach"],

            ["id"=>280, "name"=>"Role.create"],
            ["id"=>281, "name"=>"Role.read"],
            ["id"=>282, "name"=>"Role.show"],
            ["id"=>283, "name"=>"Role.showAll"],
            ["id"=>284, "name"=>"Role.showTrashed"],
            ["id"=>285, "name"=>"Role.recoveryTrashed"],
            ["id"=>286, "name"=>"Role.update"],
            ["id"=>287, "name"=>"Role.updateAll"],
            ["id"=>288, "name"=>"Role.destroy"],
            ["id"=>289, "name"=>"Role.forceDestroy"],
            ["id"=>290, "name"=>"Role.attach"],

            ["id"=>291, "name"=>"Module.create"],
            ["id"=>292, "name"=>"Module.read"],
            ["id"=>293, "name"=>"Module.show"],
            ["id"=>294, "name"=>"Module.showAll"],
            ["id"=>295, "name"=>"Module.showTrashed"],
            ["id"=>296, "name"=>"Module.recoveryTrashed"],
            ["id"=>297, "name"=>"Module.update"],
            ["id"=>298, "name"=>"Module.updateAll"],
            ["id"=>299, "name"=>"Module.destroy"],
            ["id"=>300, "name"=>"Module.forceDestroy"],
            ["id"=>301, "name"=>"Module.attach"],

            ["id"=>302, "name"=>"ModuleDefault.create"],
            ["id"=>303, "name"=>"ModuleDefault.read"],
            ["id"=>304, "name"=>"ModuleDefault.show"],
            ["id"=>305, "name"=>"ModuleDefault.showAll"],
            ["id"=>306, "name"=>"ModuleDefault.showTrashed"],
            ["id"=>307, "name"=>"ModuleDefault.recoveryTrashed"],
            ["id"=>308, "name"=>"ModuleDefault.update"],
            ["id"=>309, "name"=>"ModuleDefault.updateAll"],
            ["id"=>310, "name"=>"ModuleDefault.destroy"],
            ["id"=>311, "name"=>"ModuleDefault.forceDestroy"],
            ["id"=>312, "name"=>"ModuleDefault.attach"],

            ["id"=>313, "name"=>"ModuleGroup.create"],
            ["id"=>314, "name"=>"ModuleGroup.read"],
            ["id"=>315, "name"=>"ModuleGroup.show"],
            ["id"=>316, "name"=>"ModuleGroup.showAll"],
            ["id"=>317, "name"=>"ModuleGroup.showTrashed"],
            ["id"=>318, "name"=>"ModuleGroup.recoveryTrashed"],
            ["id"=>319, "name"=>"ModuleGroup.update"],
            ["id"=>320, "name"=>"ModuleGroup.updateAll"],
            ["id"=>321, "name"=>"ModuleGroup.destroy"],
            ["id"=>322, "name"=>"ModuleGroup.forceDestroy"],
            ["id"=>323, "name"=>"ModuleGroup.attach"],
        ]);
    }
}
