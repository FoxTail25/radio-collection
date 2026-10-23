<?php

namespace Database\Seeders;

use App\Models\Station;
use App\Models\Channel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StationSeeder extends Seeder
{
    public function run(): void
    {
        $stationsData = [
            [
                'name' => "Шоколад",
                'img' => 'img/station_logo/shokolad.svg',
                'dots' => ["https://choco.hostingradio.ru:10010/fm", "https://choco.hostingradio.ru:10010/fm?71050d68"]
            ],
            [
                'name' => "Relax.FM",
                'img' => 'img/station_logo/relax_fm.svg',
                'dots' => ["https://pub0201.101.ru:443/stream/air/aac/64/200?5660"]
            ],
            [
                'name' => "Monte Carlo",
                'img' => 'img/station_logo/monte_carlo.svg',
                'dots' => ["https://montecarlo.hostingradio.ru/montecarlo96.aacp?5d63", "https://radio.gubernia.com:8000/radio9"]
            ],
            [
                'name' => "Эльдорадио",
                'img' => 'img/station_logo/eldoradio.png',
                'dots' => ["https://emgspb.hostingradio.ru/eldoradio128.mp3", "https://europaplus.hostingradio.ru:8000/eldoradio128.mp3"]
            ],
            [
                'name' => "Авторадио",
                'img' => 'img/station_logo/avtoradio-logo.png',
                'dots' => ["https://pub0201.101.ru:443/stream/air/aac/64/100?d29e93b1"]
            ],
            [
                'name' => "DFM",
                'img' => 'img/station_logo/dfm.jpg',
                'dots' => ["https://dfm.hostingradio.ru/dfm128.mp3", "https://23.105.238.4/dfm96.aacp"]
            ],
            [
                'name' => "LikeFM",
                'img' => 'img/station_logo/like_fm.png',
                'dots' => ["https://pub0101.101.ru:8000/stream/reg/mp3/128/region_like_89"]
            ],
            [
                'name' => "Love",
                'img' => 'img/station_logo/john-love2.png',
                'dots' => ["https://centova.gr-net.gr/proxy/love/stream"]
            ],
            [
                'name' => "Tranzistor100.3",
                'img' => 'https://tranzistor1003.gr/wp-content/uploads/2022/06/300X300-TRANZISTOR-1003-LOGO-TRANSPARENT-1.png',
                'dots' => ["https://metromedia.live24.gr/tranzistor1003thess"]
            ],
            [
                'name' => "Радиокнига",
                'img' => 'https://top-radio.ru/assets/image/radio/180/kniga.jpg',
                'dots' => ["https://bookradio.hostingradio.ru:8069/fm"]
            ],
            [
                'name' => "Маруся FM",
                'img' => 'img/station_logo/marusyafm.png',
                'dots' => ["https://radio-holding.ru:9433/marusya_default"]
            ],
            [
                'name' => "Русское",
                'img' => 'https://top-radio.ru/assets/image/radio/180/rusradio.png',
                'dots' => ["https://rusradio.hostingradio.ru/rusradio96.aacp"]
            ],
            [
                'name' => "Дорожное",
                'img' => 'https://top-radio.ru/assets/image/radio/180/dorojnoe.png',
                'dots' => ["https://dorognoe.hostingradio.ru/dorognoe"]
            ],
            [
                'name' => "Европа плюс",
                'img' => 'https://top-radio.ru/assets/image/radio/180/europa-plus.png',
                'dots' => ["https://ep256.hostingradio.ru:8052/europaplus256.mp3"]
            ],
            [
                'name' => "Вести ФМ",
                'img' => 'https://top-radio.ru/assets/image/radio/180/vestifm.png',
                'dots' => ["https://icecast-vgtrk.cdnvideo.ru/vestifm_mp3_192kbps"]
            ],
            [
                'name' => "Ретро FM",
                'img' => 'https://top-radio.ru/assets/image/radio/180/retro_fm.png',
                'dots' => ["https://retro.hostingradio.ru:8043/retro256.mp3"]
            ],
            [
                'name' => "Радио Рекорд",
                'img' => 'https://top-radio.ru/assets/image/radio/180/radiorecod.png',
                'dots' => ["https://radiorecord.hostingradio.ru/rr_main96.aacp"]
            ],
            [
                'name' => "Радио ENERGY",
                'img' => 'https://top-radio.ru/assets/image/radio/180/energy.png',
                'dots' => ["https://srv21.gpmradio.ru:8443/stream/air/aac/64/99"]
            ],
            [
                'name' => "Радио 7",
                'img' => 'https://top-radio.ru/assets/image/radio/180/radio7-na7holmah.png',
                'dots' => ["https://radio7.hostingradio.ru:8040/radio7256.mp3"]
            ],
            [
                'name' => "SOUNDPARK DEEP",
                'img' => 'https://top-radio.ru/assets/image/radio/180/spdeep.jpg',
                'dots' => ["https://relay1.radiotoolkit.com/spdeep"]
            ],
            [
                'name' => "НАШЕ Радио",
                'img' => 'https://top-radio.ru/assets/image/radio/180/nase-radio.png',
                'dots' => ["https://nashe1.hostingradio.ru/nashe-256"]
            ],
            [
                'name' => "Юмор FM",
                'img' => 'https://top-radio.ru/assets/image/radio/180/humorfm.jpg',
                'dots' => ["https://srv21.gpmradio.ru:8443/stream/air/aac/64/102"]
            ],
            [
                'name' => "Хит FM",
                'img' => 'https://top-radio.ru/assets/image/radio/180/hit-fm.png',
                'dots' => ["https://hitfm.hostingradio.ru/hitfm96.aacp"]
            ],
            [
                'name' => "Радио Romantika",
                'img' => 'https://top-radio.ru/assets/image/radio/180/romantika.png',
                'dots' => ["https://srv21.gpmradio.ru:8443/stream/air/aac/64/101"]
            ],
            [
                'name' => "Радио ЗВЕЗДА",
                'img' => 'https://top-radio.ru/assets/image/radio/180/zvezda-fm.jpg',
                'dots' => ["https://zvezda-radio-rzv.mediacdn.ru/radio/zvezda/zvezda_128"]
            ],
            [
                'name' => "Радио БизнесFM",
                'img' => 'https://top-radio.ru/assets/image/radio/180/bfm-russia.png',
                'dots' => ["https://bfm.hostingradio.ru:9075/fm"]
            ],
        ];

        foreach ($stationsData as $data) {
            // Создаем саму радиостанцию
            $station = Station::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'logo' => $data['img'],
                'is_active' => true,
            ]);

            // Привязываем к ней каналы
            foreach ($data['dots'] as $index => $url) {
                Channel::create([
                    'station_id' => $station->id,
                    'name' => $index === 0 ? 'Основной поток' : 'Дополнительный поток ' . $index,
                    'stream_url' => $url,
                    'is_main' => $index === 0, // Первый элемент массива становится главным
                ]);
            }
        }
    }
}
