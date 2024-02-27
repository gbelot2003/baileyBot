<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('products')->delete();
        
        \DB::table('products')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Cama de Agua',
                'tag' => 'camas',
                'description' => 'Cama de agua anti blists',
                'price' => 2563.05,
                'image_url' => 'https://www.tiendameyko.com/web/image/product.product/11/image_1024/%5BTM600%5D%20COLCH%C3%93N%20DE%20AGUA%20-%20THERAFLOAT%C2%AE?unique=db04bd8',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'BANCO GIRATORIO SIN RESPALDAR',
                'tag' => 'sillas',
                'description' => 'BANCO GIRATORIO SIN RESPALDAR',
                'price' => 750.25,
                'image_url' => 'https://www.tiendameyko.com/web/image/product.product/107/image_1024/%5BSS7677%5D%20BANCO%20GIRATORIO%20SIN%20RESPALDAR?unique=db04bd8',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'COLCHÓN DE AIRE CON PRESIÓN AJUSTABLE',
                'tag' => 'camas',
                'description' => 'COLCHÓN DE AIRE CON PRESIÓN AJUSTABLE',
                'price' => 2350.0,
                'image_url' => 'https://www.tiendameyko.com/web/image/product.product/268/image_1024/%5BAPP-2000-GBN%5D%20COLCH%C3%93N%20DE%20AIRE%20CON%20PRESI%C3%93N%20AJUSTABLE?unique=db04bd8',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'ANTIFAZ PARA ALIVIAR DOLOR - IMAK® Eye Pillow ™',
                'tag' => 'miselaneos',
                'description' => 'ANTIFAZ PARA ALIVIAR DOLOR - IMAK® Eye Pillow ™',
                'price' => 500.0,
                'image_url' => 'https://www.tiendameyko.com/web/image/product.product/90/image_1024/%5BA30131%5D%20ANTIFAZ%20PARA%20ALIVIAR%20DOLOR%20-%20IMAK%C2%AE%20Eye%20Pillow%20%E2%84%A2?unique=db04bd8',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => '
BOLSA DE AGUA CALIENTE - Rojo',
                'tag' => 'miselaneos',
                'description' => '
BOLSA DE AGUA CALIENTE - Rojo',
                'price' => 355.5,
                'image_url' => 'https://www.tiendameyko.com/web/image/product.product/153/image_1024/%5B42-840-000%5D%20BOLSA%20DE%20AGUA%20CALIENTE%20-%20Rojo?unique=db04bd8',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}