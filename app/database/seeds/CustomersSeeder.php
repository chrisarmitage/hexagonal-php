<?php

class CustomersSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        DB::table('customers')->delete();
        
        $seedArray = array(
            array(
                'reference' => '1000',
                'name' => 'C Armitage',
                'category' => 'DPG',
            ),
            array(
                'reference' => '1001',
                'name' => 'M Reynolds',
                'category' => 'PG',
            ),
            array(
                'reference' => '1002',
                'name' => 'K Frye',
                'category' => 'PG',
            ),
            array(
                'reference' => '1005',
                'name' => 'A Niska',
                'category' => 'DPUG',
            ),
        );
        
        foreach ($seedArray as $customer) {
            DB::insert(
                'INSERT INTO customers (reference, name, category) values (:reference, :name, :category)',
                $customer
            );
        }
	}

}
