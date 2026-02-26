<?php

use App\Models\Currency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('s_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Currency::create([
            'name' => "So'm",
            's_code' => "UZS",
        ]);

        Currency::create([
                             'name' => "Dollar",
                             's_code' => "USD",
                         ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
