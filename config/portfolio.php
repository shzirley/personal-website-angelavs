<?php

// Reconciled against Angela's portfolio, September 2026 resume, and BRIN
// certificate. The newest resume takes precedence for current roles.
return [
    'name' => 'Angela Vania Sugiyono',
    'short_name' => 'Angela',
    'nrp' => '5025241226',
    'degree' => 'Informatics Engineering',
    'university' => 'Institut Teknologi Sepuluh Nopember',
    'location' => 'Surabaya, Indonesia',
    'intro' => 'An Informatics student at ITS, usually somewhere between a research rabbit hole, a Figma file, and a very long playlist.',
    'about' => 'I like figuring out how things work - from the systems underneath an app to the little details that make it feel right. These days, I split my time between AI projects, teaching labs, and building things with people who are just as curious.',
    'education' => [
        ['school' => 'Institut Teknologi Sepuluh Nopember', 'degree' => 'BSc in Informatics Engineering', 'period' => '2024 - present', 'score' => '3.29 / 4.00'],
        ['school' => 'SMA Negeri 2 Surakarta', 'degree' => 'Natural Sciences', 'period' => '2021 - 2024', 'score' => '91.42 / 100.00'],
    ],
    'skills' => ['C / C++', 'Python', 'PHP', 'HTML / CSS', 'Figma', 'MySQL', 'Linux', 'Operating Systems', 'Computer Networks', 'Database Design', 'GitHub', 'Railway'],
    'soft_skills' => ['Research', 'Problem solving', 'Project management', 'Leadership', 'Public speaking', 'Mentorship', 'Teamwork'],
    'contact' => ['email' => 'angelasugiyono95@gmail.com', 'linkedin' => 'https://linkedin.com/in/angelavs', 'github' => 'https://github.com/shzirley'],
    'experience' => [
        ['period' => 'Sep 2026 - present', 'role' => 'Computer Network Teaching Assistant', 'organization' => 'Institut Teknologi Sepuluh Nopember', 'description' => 'Guiding 90+ students through GNS3, subnetting, routing, DNS, DHCP, and firewalls - and helping untangle the parts that do not quite connect.'],
        ['period' => 'Aug 2026 - present', 'role' => 'Frontend Developer', 'organization' => 'ITS Nabu', 'description' => 'Building frontend features for user monitoring and cybersecurity activities, plus platforms for seminars, events, and community engagement.'],
        ['period' => 'Mar 2026 - present', 'role' => 'Operating Systems Teaching Assistant', 'organization' => 'Institut Teknologi Sepuluh Nopember', 'description' => 'Mentoring 80+ students in Linux, IPC, booting, and FUSE through C/C++ reviews, debugging sessions, and hands-on filesystem modules.'],
    ],
    'community' => [
        ['period' => 'Mar 2026 - present', 'role' => 'Research & Technology Staff', 'organization' => 'HMTC ITS', 'description' => 'Leading Elite TC with 15 mentors and 5 volunteers, shaping Bluecamp for 80+ first-year students, and leading a malware-analysis seminar.'],
        ['period' => 'Mar 2025 - present', 'role' => 'Expert Staff, Data Management', 'organization' => 'SCHEMATICS', 'description' => 'Automating registration and administration for 800+ participants and coordinating data across divisions.'],
        ['period' => 'Apr - Jun 2025', 'role' => 'General Secretary of Administration', 'organization' => 'Youth Green Hackathon', 'description' => 'Keeping documentation and administration on track for a ChildFund-supported climate project with 475 webinar participants and five ideas incubated.'],
        ['period' => 'Nov 2024 - Feb 2025', 'role' => 'Material & Method Staff', 'organization' => 'SOLITS', 'description' => 'Introducing ITS to students around Surakarta and helping the team deliver clear, engaging education sessions.'],
        ['period' => 'Aug 2022 - Aug 2024', 'role' => 'Institutional Division', 'organization' => 'Forum Anak Karanganyar', 'description' => 'Preparing educational materials on children’s rights and supporting a space for young people to share their needs and ideas.'],
        ['period' => 'Jan 2022 - Dec 2023', 'role' => 'Vice Chair', 'organization' => 'KIRSMADA', 'description' => 'Helping members develop research ideas, planning scientific activities, and setting shared goals for the team.'],
        ['period' => 'Nov 2022 - Jan 2023', 'role' => 'Member', 'organization' => 'Rumah Teknologi', 'description' => 'Working on Green Saldo, a Kodular-built Android app connecting waste management with local small businesses.'],
    ],
    'projects' => [
        'claritas' => [
            'title' => 'CLARITAS', 'category' => 'AI / HEALTH-TECH', 'role' => 'Chief Operating Officer (COO)', 'year' => '2026 - present',
            'summary' => 'An AI health-tech platform supporting Alzheimer’s risk screening through linguistic analysis.',
            'image' => 'claritas_mockup.png',
            'description' => 'CLARITAS brings linguistic analysis into early risk screening to support medical professionals. As COO, I focus on turning plans into delivery - keeping internal product development moving and connecting it with our external strategy.',
            'responsibilities' => ['Drive implementation and the day-to-day execution of internal product development.', 'Coordinate product delivery with external strategy and team priorities.', 'Help turn the product into a fundable venture: CLARITAS secured IDR 17,500,000 from ITS Youth Technopreneur.'],
            'highlight' => 'IDR 17.5M - ITS Youth Technopreneur funding',
        ],
        'tappcom' => [
            'title' => 'TAPPCOM', 'category' => 'PRODUCT / UI & UX', 'role' => 'Product Developer / UI-UX Designer', 'year' => '2023',
            'summary' => 'Helping local tailors find their place in a more digital world.', 'image' => 'tappcom_mockup.png',
            'description' => 'Tailor App Community is an Android app designed for local tailoring businesses. The idea is simple: make their services easier to discover while helping tailors build a recognisable online presence.',
            'responsibilities' => ['Develop the product concept and its mobile user experience.', 'Translate familiar tailoring services into a digital customer journey.', 'Support wider market reach and stronger branding for local tailoring MSMEs.'],
            'highlight' => 'Android - community-centred product design',
        ],
        'green-saldo' => [
            'title' => 'Green Saldo', 'category' => 'ANDROID / SUSTAINABILITY', 'role' => 'Application Developer - Rumah Teknologi', 'year' => '2023',
            'summary' => 'A second life for everyday waste, with local businesses in the loop.', 'image' => null,
            'description' => 'Built with Kodular as part of Rumah Teknologi, Green Saldo explores how recycling and reuse can become more collaborative by connecting waste-management efforts with small businesses.',
            'responsibilities' => ['Develop an Android application using Kodular.', 'Explore a recycling and reuse workflow for local waste management.', 'Connect the concept with small-business participation and useful end products.'],
            'highlight' => 'Kodular - recycling & reuse',
        ],
    ],
    // Newest documented year first; unknown exact dates are not invented.
    'achievements' => [
        ['id' => 'brin', 'year' => 2026, 'title' => 'Finalist', 'event' => 'BRIN AIDeaNation', 'organizer' => 'National Research and Innovation Agency (BRIN)', 'description' => 'AI for Sustainable Future - 11-13 August 2026.', 'image' => 'ach_2026_brin.png', 'document' => 'brin-aideanation-2026.pdf'],
        ['id' => 'datathon', 'year' => 2026, 'title' => 'Semifinalist', 'event' => 'Datathon RISTEK UI', 'organizer' => 'RISTEK - Universitas Indonesia', 'description' => 'A data-focused competition and another reason to keep exploring machine learning.', 'image' => null, 'document' => null],
        ['id' => 'hult', 'year' => 2026, 'title' => 'Top 8 National Finalist', 'event' => 'Hult Prize Indonesia', 'organizer' => 'Hult Prize Indonesia', 'description' => 'Taking CLARITAS to the national final pitch round.', 'image' => 'ach_2026_hultprize.png', 'document' => null],
        ['id' => 'dinacom', 'year' => 2026, 'title' => 'Top 10 National Finalist', 'event' => 'Dinus App Competition 11.0', 'organizer' => 'Universitas Dian Nuswantoro', 'description' => 'An app-building competition, a team effort, and plenty of learning along the way.', 'image' => 'ach_2025_dinacom.png', 'document' => null],
        ['id' => 'digihack', 'year' => 2025, 'title' => 'Top 50 National Finalist', 'event' => 'DigiHack - Digistar Club', 'organizer' => 'Telkom Indonesia', 'description' => 'AI for Good - Empowering Innovation with Telkom Group.', 'image' => 'ach_2025_digihack.png', 'document' => null],
        ['id' => 'tidar', 'year' => 2023, 'title' => 'Finalist', 'event' => 'Scientific Festival', 'organizer' => 'Universitas Tidar', 'description' => 'A national essay competition, recognised among the top five finalists.', 'image' => 'ach_2023_tidar.png', 'document' => null],
        ['id' => 'unesa', 'year' => 2023, 'title' => 'Finalist', 'event' => 'National Essay Competition (LEN)', 'organizer' => 'Universitas Negeri Surabaya', 'description' => 'A national essay exploring ideas for Indonesia’s future.', 'image' => 'ach_2023_unesa.png', 'document' => null],
        ['id' => 'nsec', 'year' => 2023, 'title' => '3rd Place', 'event' => 'National Scientific Essay Competition', 'organizer' => 'Universitas Sebelas Maret', 'description' => 'One of the early research milestones that made me want to keep going.', 'image' => 'ach_2023_nsec.png', 'document' => null],
    ],
    'music' => [
        'title' => 'ROS', 'artist' => 'Mac Miller', 'album' => 'GO:OD AM',
        'youtube_id' => '-2AfeMnpiRI', 'youtube_url' => 'https://www.youtube.com/watch?v=-2AfeMnpiRI',
        'lyrics_url' => 'https://music.apple.com/us/song/ros/1025258292',
        'spotify_url' => 'https://open.spotify.com/track/388jD8ko9cvFM9cd9TYDrl',
        'minutes' => 56000, 'year' => 2025,
    ],
];
