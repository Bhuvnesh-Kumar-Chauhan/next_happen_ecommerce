<?php

declare(strict_types=1);

use Bavix\Wallet\Models\Wallet;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    public function up(): void
    {
        Schema::create($this->table(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('holder');
            $table->string('name');
            $table->string('slug', 191)->charset('utf8')->collation('utf8_unicode_ci')->index();
            $table->uuid('uuid')->unique();
            $table->string('description')->nullable();
            $table->json('meta')->nullable();
            $table->decimal('balance', 64, 0)->default(0);
            $table->unsignedSmallInteger('decimal_places')->default(2);
            $table->timestamps();

            $table->unique(['holder_type', 'holder_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists($this->table());
    }

    protected function table(): string
    {
        return (new Wallet())->getTable();
    }
}
