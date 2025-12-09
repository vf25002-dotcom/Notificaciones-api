<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabla: roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id('ROLE_ID'); // numeric, Identificador único del rol
            $table->text('ROLE_CODE')->nullable();
            $table->text('ROLE_NAME')->nullable();
            $table->text('ROLE_DESCRIPTION')->nullable();
            $table->integer('ROLE_STATUS')->default(1); // numeric
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabla: permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->id('ID'); // numeric, Identificador único del permiso
            $table->text('PERM_CODE')->nullable();
            $table->text('PERM_NAME')->nullable();
            $table->text('PERM_DESCRIPTION')->nullable();
            $table->text('PERM_MENU_AREA')->nullable();
            $table->text('PERM_ROUTE_NAME')->nullable();
            $table->text('PERM_CONTROLLER')->nullable();
            $table->text('PERM_ACTION')->nullable();
            $table->text('PERM_MENU_PARENT_LABEL')->nullable();
            $table->text('PERM_MENU_PARENT_GROUP')->nullable();
            $table->integer('PERM_MENU_PARENT_ID')->nullable(); // numeric
            $table->integer('PERM_MENU_ORDER')->nullable(); // numeric
            $table->integer('PERM_STATUS')->default(1); // numeric
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabla: usuarios
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('ID'); // numeric, Identificador único del usuario
            $table->text('USUARIO');
            $table->text('PASSWORD');
            $table->text('SUCURSAL')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabla: user_role
        Schema::create('user_role', function (Blueprint $table) {
            $table->id('USER_ROLE_ID'); // numeric
            $table->unsignedBigInteger('USER_ID'); // numeric
            $table->unsignedBigInteger('ROLE_ID'); // numeric
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('USER_ID')->references('ID')->on('usuarios')->onDelete('cascade');
            $table->foreign('ROLE_ID')->references('ROLE_ID')->on('roles')->onDelete('cascade');
        });

        // Tabla: roles_permissions
        Schema::create('roles_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('ROLE_ID'); // numeric
            $table->unsignedBigInteger('PERM_ID'); // numeric
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ROLE_ID')->references('ROLE_ID')->on('roles')->onDelete('cascade');
            $table->foreign('PERM_ID')->references('ID')->on('permissions')->onDelete('cascade');

            // Primary key compuesta para evitar duplicados
            $table->primary(['ROLE_ID', 'PERM_ID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_permissions');
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
