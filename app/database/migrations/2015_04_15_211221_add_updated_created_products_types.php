<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class AddUpdatedCreatedProductsTypes extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //add time stamps
        Schema::table('products_types', function($table) {
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //drop the time stamps
        Schema::table('products_types', function($table) {
            $table->dropTimestamps();
        });
    }
}