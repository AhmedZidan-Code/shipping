<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('governorate', 50)->nullable()->after('app_name');
            $table->string('phones')->nullable()->after('governorate');
            $table->string('email')->nullable()->after('phones');
            $table->mediumText('address')->nullable()->after('email');
            $table->double('lat')->default(29.953030)->after('address');
            $table->double('lng')->default(31.276623)->after('lat');
            $table->string('facebook')->nullable()->after('lng');
            $table->string('twitter')->nullable()->after('facebook');
            $table->string('linkedin')->nullable()->after('twitter');
            $table->string('youtube')->nullable()->after('linkedin');
            $table->text('terms_and_condition')->nullable()->after('youtube');
            $table->text('privacy_policy')->nullable()->after('terms_and_condition');
            $table->text('legal')->nullable()->after('privacy_policy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'governorate',
                'phones',
                'email',
                'address',
                'lat',
                'lng',
                'facebook',
                'twitter',
                'linkedin',
                'youtube',
                'terms_and_condition',
                'privacy_policy',
                'legal',
            ]);
        });
    }
}
