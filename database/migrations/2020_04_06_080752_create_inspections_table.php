<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->string('id')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('stage')->nullable();
            $table->string('date')->nullable();
            $table->string('mileage')->nullable();
            $table->string('regnumber')->nullable();
            $table->string('fuel')->nullable();
            $table->string('lightfront')->nullable();
            $table->string('lightrear')->nullable();
            $table->string('indicators')->nullable();
            $table->string('wingmirrors')->nullable();
            $table->string('mirrorrear')->nullable();
            $table->string('windscreen')->nullable();
            $table->string('rearwindow')->nullable();
            $table->string('wipers')->nullable();
            $table->string('radioorrape')->nullable();
            $table->string('speakers')->nullable();
            $table->string('aerial')->nullable();
            $table->string('radiolicence')->nullable();
            $table->string('radioface')->nullable();
            $table->string('cdshuttle')->nullable();
            $table->string('fireextinguisher')->nullable();
            $table->string('keys')->nullable();
            $table->string('ashtray')->nullable();
            $table->string('lighter')->nullable();
            $table->string('floormats')->nullable();
            $table->string('spanners')->nullable();
            $table->string('wheelspanners')->nullable();
            $table->string('wheelnut')->nullable();
            $table->string('wheeltyres')->nullable();
            $table->string('sparewheel')->nullable();
            $table->string('hubcaps')->nullable();
            $table->string('jack')->nullable();
            $table->string('jackhandle')->nullable();
            $table->string('pliers')->nullable();
            $table->string('triangles')->nullable();
            $table->string('toolbar')->nullable();
            $table->string('reflectivejacket')->nullable();
            $table->string('paintwork')->nullable();
            $table->string('bullbars')->nullable();
            $table->string('upholstery')->nullable();
            $table->string('seatbelts')->nullable();
            $table->string('locks')->nullable();
            $table->string('alarmsystem')->nullable();
            $table->string('centrallocking')->nullable();
            $table->string('battery')->nullable();
            $table->string('hooter')->nullable();
            $table->string('canopy')->nullable();
            $table->string('fuelcap')->nullable();
            $table->string('oilcap')->nullable();
            $table->string('oildipstick')->nullable();
            $table->string('windshields')->nullable();
            $table->string('spotlights')->nullable();
            $table->string('cleanliness')->nullable();
            $table->string('remarks')->nullable();
            $table->bigIncrements('uuid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspections');
    }
}
