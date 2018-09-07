var ap1 = new APlayer({
    element: document.getElementById('musicplayer'),
    narrow: false,
    autoplay: false,
    showlrc: false,
    mutex: true,
    theme: '#A21319',
    music: [
        {
            title: 'Не забувай',
            author: 'YEGANOV Project',
            url: '/assets/audio/YEGANOV_Project-Ne.mp3',
            pic: '/assets/img/112.jpg'
        },
        {
            title: 'Пісня вільна',
            author: 'YEGANOV Project',
            url: '/assets/audio/YEGANOV_Project-Vilna.mp3',
            pic: '/assets/img/112.jpg'
        },
        {
            title: 'Казкове рандеву',
            author: 'YEGANOV Project',
            url: '/assets/audio/YEGANOV_Project-Randevu.mp3',
            pic: '/assets/img/112.jpg'
        },
		{
            title: 'Рок-н-рольний дух',
            author: 'YEGANOV Project',
            url: '/assets/audio/YEGANOV_Project_RNR.mp3',
            pic: '/assets/img/112.jpg'
        },
		{
            title: 'Бомба',
            author: 'YEGANOV Project',
            url: '/assets/audio/YEGANOV_Project-Bomba.mp3',
            pic: '/assets/img/112.jpg'
        },
		{
            title: 'Хитра лисиця',
            author: 'YEGANOV Project',
            url: '/assets/audio/YEGANOV_ProjectLisa.mp3',
            pic: '/assets/img/112.jpg'
        },
		{
			title: 'Танго на попелі',
            author: 'YEGANOV Project',
            url: '/assets/audio/YEGANOV_Project_Tango.mp3',
            pic: '/assets/img/112.jpg'
		}
    ]
});
ap1.init();
