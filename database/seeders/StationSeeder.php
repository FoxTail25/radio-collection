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
                'img' => 'https://chocoradio.ru/local/templates/site/assets/dist/images/logo.svg?c4a599052e279cce771cdf5ccbfe673f',
                'dots' => ["https://choco.hostingradio.ru:10010/fm", "https://choco.hostingradio.ru:10010/fm?71050d68"]
            ],
            [
                'name' => "Relax.FM",
                'img' => 'https://cdnec2.relax-fm.ru/design/images/img_for_design/re_design/main_logo.svg',
                'dots' => ["https://pub0201.101.ru:443/stream/air/aac/64/200?5660"]
            ],
            [
                'name' => "Monte Carlo",
                'img' => 'https://montecarlo.ru/b/d/XS_d975tAlcebtpOMjesWp5sKuUPWgoJaZDwNc_THtXuPg6lciF6nlNfCDQd5U1ShzdY7aLzQL7HHYqksS-CX15bDDVBjcIGFxq8=FxbNEVU59fv1-ngTFwNzPQ.webp',
                'dots' => ["https://montecarlo.hostingradio.ru/montecarlo96.aacp?5d63", "https://radio.gubernia.com:8000/radio9"]
            ],
            [
                'name' => "Эльдорадио",
                'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSC9LaLbh3KF3E8uDaD7SyadkOvdC3dTqE8UYaJBBKFuQ&s',
                'dots' => ["https://emgspb.hostingradio.ru/eldoradio128.mp3", "https://europaplus.hostingradio.ru:8000/eldoradio128.mp3"]
            ],
            [
                'name' => "Авторадио",
                'img' => 'https://www.avtoradio.ru/design/images/site-design/avtoradio-logo.png',
                'dots' => ["https://pub0201.101.ru:443/stream/air/aac/64/100?d29e93b1"]
            ],
            [
                'name' => "DFM",
                'img' => 'https://toplogos.ru/images/logo-dfm.png',
                'dots' => ["https://dfm.hostingradio.ru/dfm128.mp3", "https://23.105.238.4/dfm96.aacp"]
            ],
            [
                'name' => "LikeFM",
                'img' => 'https://upload.wikimedia.org/wikipedia/commons/7/73/LikeFM_logo.jpg?utm_source=ru.wikipedia.org&utm_campaign=index&utm_content=original',
                'dots' => ["https://pub0101.101.ru:8000/stream/reg/mp3/128/region_like_89"]
            ],
            [
                'name' => "Love",
                'img' => 'https://play-lh.googleusercontent.com/rLsdZbJ9lQwhxGKKu2sPCLQ-sK2SMFGiDd6B_wqVLnEv3gRm0okaVfWpGOy5K8bHLd6W4Dsg2hf5c6nHsdt44IA',
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
                'img' => 'https://marus.fm/img/logo2.png',
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
