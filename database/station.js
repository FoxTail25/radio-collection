const radioStation = [
    {
        name: "Шоколад",
        category: ["relax", "pop"],
        favorites:false,
        // img: 'https://chocoradio.ru/local/templates/site/assets/dist/images/logo.svg?6f4626bc151e087f9d70ff58807b939c',
        img: 'img/station_logo/shokolad.svg',
        radioDot: {
            dot_1: {
                href: "https://choco.hostingradio.ru:10010/fm"
            },
            dot_2: {
                href: "https://choco.hostingradio.ru:10010/fm?71050d68",
            }
        }
    },
    {
        name: "Relax.FM",
        category: ["relax"],
        favorites:false,
        img: 'img/station_logo/relax_fm.svg',
        radioDot: {
            dot_1: {
                href: "https://pub0201.101.ru:443/stream/air/aac/64/200?5660"
            }
        }
    },
    {
        name: "Monte Carlo",
        category: ["pop"],
        favorites:false,
        img: 'img/station_logo/monte_carlo.svg',
        radioDot: {
            dot_1: {
                href: "https://montecarlo.hostingradio.ru/montecarlo96.aacp?5d63",
            },
            dot_2: {
                href: "https://radio.gubernia.com:8000/radio9",
            }
        }
    },
    {
        name: "Эльдорадио",
        category: ["шансон"],
        favorites:false,
        img: 'img/station_logo/eldoradio.png',
        radioDot: {
            dot_1: {
                href: "https://emgspb.hostingradio.ru/eldoradio128.mp3",
            },
            dot_2: {
                href: "https://europaplus.hostingradio.ru:8000/eldoradio128.mp3",
            }
        }
    },
    {
        name: "Авторадио",
        category: ["pop"],
        favorites:false,
        img: 'img/station_logo/avtoradio-logo.png',
        radioDot: {
            dot_1: {
                href: "https://pub0201.101.ru:443/stream/air/aac/64/100?d29e93b1",
            },
            dot_2: {
                // href: "http://europaplus.hostingradio.ru:8000/eldoradio128.mp3",
            }
        }
    },
    {
        name: "DFM",
        category: ["pop", "dance"],
        favorites:false,
        img: 'img/station_logo/dfm.jpg',
        radioDot: {
            dot_1: {
                href: "https://dfm.hostingradio.ru/dfm128.mp3",
                // href: "http://23.105.238.4/dfm128.mp3",
                format: 'mp3',
                location:"Moskow"
            },
            dot_2: {
                href: "https://23.105.238.4/dfm96.aacp",
                // href: "https://dfm.hostingradio.ru/dfm96.aacp",
                format: 'acc',
                location:"Moskow",
            }
        }
    },
    {
        name: "LikeFM",
        category: ["pop"],
        favorites:false,
        img: 'img/station_logo/like_fm.png',
        radioDot: {
            dot_1: {
                href: "https://pub0101.101.ru:8000/stream/reg/mp3/128/region_like_89",
                format: 'mp3',
                location:"Воронеж"
            },

        }
    },
    {
        name: "Love",
        category: ["pop"],
        favorites:false,
        img: 'img/station_logo/john-love2.png',
        radioDot: {
            dot_1: {
                href: "https://centova.gr-net.gr/proxy/love/stream",
                format: 'mp3',
                location:"Греция, Солоники"
            },
        }
    },
    {
        name: "Tranzistor100.3",
        category: ["pop"],
        favorites:false,
        img: 'https://tranzistor1003.gr/wp-content/uploads/2022/06/300X300-TRANZISTOR-1003-LOGO-TRANSPARENT-1.png',
        radioDot: {
            dot_1: {
                href: "https://metromedia.live24.gr/tranzistor1003thess",
                format: 'mp3',
                location:"Греция, Солоники",
            },
        }
    },
    {
        name: "Радиокнига",
        category: ["pop"],
        favorites:false,
        img: 'https://top-radio.ru/assets/image/radio/180/kniga.jpg',
        radioDot: {
            dot_1: {
                href: "https://bookradio.hostingradio.ru:8069/fm",
                format: 'mp3',
                location:"",
            },
        }
    },
    {
        name: "Маруся FM",
        category: ["pop"],
        favorites:false,
        img: 'img/station_logo/marusyafm.png',
        radioDot: {
            dot_1: {
                href: "https://radio-holding.ru:9433/marusya_default",
                format: '',
                location:"",
            },
        }
    },
    {
        name: "Русское",
        category: ["pop"],
        favorites:false,
        img: 'https://top-radio.ru/assets/image/radio/180/rusradio.png',
        radioDot: {
            dot_1: {
                href: "https://rusradio.hostingradio.ru/rusradio96.aacp",
                format: '',
                location:"",
            },
        }
    },
    {
        name: "Дорожное",
        category: ["pop"],
        favorites:false,
        img: 'https://top-radio.ru/assets/image/radio/180/dorojnoe.png',
        radioDot: {
            dot_1: {
                href: "https://dorognoe.hostingradio.ru/dorognoe",
                format: '',
                location:"",
            },
        }
    },
    {
        name: "Европа плюс",
        category: ["pop"],
        favorites:false,
        img: 'https://top-radio.ru/assets/image/radio/180/europa-plus.png',
        radioDot: {
            dot_1: {
                href: "https://ep256.hostingradio.ru:8052/europaplus256.mp3",
                format: '',
                location:"",
            },
        }
    },
    {
        name: "Вести ФМ",
        category: ["pop"],
        favorites:false,
        img: 'https://top-radio.ru/assets/image/radio/180/vestifm.png',
        radioDot: {
            dot_1: {
                href: "https://icecast-vgtrk.cdnvideo.ru/vestifm_mp3_192kbps",
                format: '',
                location:"",
            },
        }
    },
    {
        name: "Ретро FM",
        category: ["pop"],
        favorites:false,
        img: 'https://top-radio.ru/assets/image/radio/180/retro_fm.png',
        radioDot: {
            dot_1: {
                href: "https://retro.hostingradio.ru:8043/retro256.mp3",
                format: '',
                location:"",
            },
        }
    },
    {
        name: "Радио Рекорд",
        category: ["pop"],
        favorites:false,
        img: 'https://top-radio.ru/assets/image/radio/180/radiorecod.png',
        radioDot: {
            dot_1: {
                href: "https://radiorecord.hostingradio.ru/rr_main96.aacp",
                format: '',
                location:"",
            },
        }
    },
    {
        name: "Радио ENERGY",
        category: ["pop"],
        favorites:false,
        img: 'https://top-radio.ru/assets/image/radio/180/energy.png',
        radioDot: {
            dot_1: {
                href: "https://srv21.gpmradio.ru:8443/stream/air/aac/64/99",
                format: '',
                location:"",
            },
        }
    },
    {
        name: "Радио 7",
        category: ["pop"],
        favorites:false,
        img: 'https://top-radio.ru/assets/image/radio/180/radio7-na7holmah.png',
        radioDot: {
            dot_1: {
                href: "https://radio7.hostingradio.ru:8040/radio7256.mp3",
                format: '',
                location:"",
            },
        }
    },
    {
        name: "SOUNDPARK DEEP",
        category: ["pop"],
        favorites:false,
        img: 'https://top-radio.ru/assets/image/radio/180/spdeep.jpg',
        radioDot: {
            dot_1: {
                href: "https://relay1.radiotoolkit.com/spdeep",
                format: '',
                location:"",
            },
        }
    },
    {
        name: "НАШЕ Радио",
        category: ["pop"],
        favorites:false,
        img: 'https://top-radio.ru/assets/image/radio/180/nase-radio.png',
        radioDot: {
            dot_1: {
                href: "https://nashe1.hostingradio.ru/nashe-256",
                format: '',
                location:"",
            },
        }
    },
    {
        name: "Юмор FM",
        category: ["pop"],
        favorites:false,
        img: 'https://top-radio.ru/assets/image/radio/180/humorfm.jpg',
        radioDot: {
            dot_1: {
                href: "https://srv21.gpmradio.ru:8443/stream/air/aac/64/102",
                format: '',
                location:"",
            },
        }
    },
    {
        name: "Хит FM",
        category: ["pop"],
        favorites:false,
        img: 'https://top-radio.ru/assets/image/radio/180/hit-fm.png',
        radioDot: {
            dot_1: {
                href: "https://hitfm.hostingradio.ru/hitfm96.aacp",
                format: '',
                location:"",
            },
        }
    },
    {
        name: "Радио Дача",
        category: ["pop"],
        favorites:false,
        img: 'https://top-radio.ru/assets/image/radio/180/radio-dacha.png',
        radioDot: {
            dot_1: {
                href: "https://stream2.n340.com/12_dacha_64_reg_1093?type=aac&UID=8EBA0473F1C84552DDD158254380DB47",
                // href: "https://stream2.n340.com/12_dacha_64_reg_1093",
                format: '',
                location:"",
            },
        }

    },
    {
        name: "Радио Romantika",
        category: ["pop"],
        favorites:false,
        img: 'https://top-radio.ru/assets/image/radio/180/romantika.png',
        radioDot: {
            dot_1: {
                href: "https://srv21.gpmradio.ru:8443/stream/air/aac/64/101",
                format: '',
                location:"",
            },
        }
    },
    {
        name: "Радио ЗВЕЗДА",
        category: ["pop"],
        favorites:false,
        img: 'https://top-radio.ru/assets/image/radio/180/zvezda-fm.jpg',
        radioDot: {
            dot_1: {
                href: "https://zvezda-radio-rzv.mediacdn.ru/radio/zvezda/zvezda_128",
                format: '',
                location:"",
            },
        }

    },
    {
        name: "Радио БизнесFM",
        category: ["pop"],
        favorites: false,
        img: 'https://top-radio.ru/assets/image/radio/180/bfm-russia.png',
        radioDot: {
            dot_1: {
                href: "https://bfm.hostingradio.ru:9075/fm",
                format: '',
                location: "",
            },
        }

    },
]

export default radioStation
