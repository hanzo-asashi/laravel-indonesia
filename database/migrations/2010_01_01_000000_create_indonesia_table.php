<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndonesiaTable extends Migration
{
    public function up(): void
    {
        Schema::create(config('indonesia.table_prefix').'provinces', function (Blueprint $table) {
            $table->id('province_id');
            $table->char('code', 2)->unique()->index();
            $table->string('name', 255);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
        });

        Schema::create(config('indonesia.table_prefix').'cities', function (Blueprint $table) {
            $table->id('city_id');
            $table->char('code', 4)->unique();
            $table->char('province_code', 2);
            $table->string('name', 255);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->foreignId('province_id')
                ->constrained(config('indonesia.table_prefix').'provinces', 'province_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('province_code')
                ->references('code')
                ->on(config('indonesia.table_prefix').'provinces')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });

        Schema::create(config('indonesia.table_prefix').'districts', function (Blueprint $table) {
            $table->id('district_id');
            $table->char('code', 7)->unique()->index();
            $table->char('city_code', 4);
            $table->string('name', 255);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->foreignId('city_id')
                ->constrained(config('indonesia.table_prefix').'cities', 'city_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('city_code')
                ->references('code')
                ->on(config('indonesia.table_prefix').'cities')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });

        Schema::create(config('indonesia.table_prefix').'villages', function (Blueprint $table) {
            $table->id('village_id');
            $table->char('code', 10)->unique()->index();
            $table->char('district_code', 7);
            $table->string('name', 255);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('postal_code')->nullable();

            $table->foreignId('district_id')
                ->constrained(config('indonesia.table_prefix').'districts','district_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('district_code')
                ->references('code')
                ->on(config('indonesia.table_prefix').'districts')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::drop(config('indonesia.table_prefix').'provinces');

        Schema::drop(config('indonesia.table_prefix').'cities');

        Schema::drop(config('indonesia.table_prefix').'districts');

        Schema::drop(config('indonesia.table_prefix').'villages');
    }
};
