document.addEventListener('DOMContentLoaded', function () {
    // Admin sidebar: collapse by default, expand on hover/focus
    const adminShell = document.querySelector('.admin-shell');
    const adminSidebar = document.querySelector('.admin-sidebar');
    if (adminShell && adminSidebar) {
        const expand = () => adminShell.classList.add('sidebar-expanded');
        const collapse = () => adminShell.classList.remove('sidebar-expanded');

        // Hover behavior
        adminSidebar.addEventListener('mouseenter', expand);
        adminSidebar.addEventListener('mouseleave', () => {
            // Keep expanded if focus is still inside sidebar
            if (!adminSidebar.matches(':focus-within')) {
                collapse();
            }
        });

        // Focus behavior (keyboard navigation)
        adminSidebar.addEventListener('focusin', expand);
        adminSidebar.addEventListener('focusout', () => {
            // If the next focused element is outside the sidebar, collapse
            setTimeout(() => {
                if (!adminSidebar.matches(':focus-within') && !adminSidebar.matches(':hover')) {
                    collapse();
                }
            }, 0);
        });

        // Start collapsed
        collapse();
    }

    // Admin Login functionality
    const adminButton = document.querySelector('.adminLoginButton');
    const loginDialog = document.querySelector('.loginDialog');
    const closeModal = document.querySelector('.closeModal');
    if (adminButton && loginDialog) {
        adminButton.addEventListener('click', function () {
            loginDialog.showModal();
        });
    }

    if (closeModal && loginDialog) {
        closeModal.addEventListener('click', function () {
            loginDialog.close();
        });
    }

    // Admin modals (Approvals / Admin users)
    const userApprovalsModal = document.getElementById('userApprovalsModal');
    const openUserApprovalsModal = document.getElementById('openUserApprovalsModal');
    const closeUserApprovalsModal = document.querySelector('.closeUserApprovalsModal');

    if (openUserApprovalsModal && userApprovalsModal) {
        openUserApprovalsModal.addEventListener('click', function () {
            userApprovalsModal.showModal();
        });
    }
    if (closeUserApprovalsModal && userApprovalsModal) {
        closeUserApprovalsModal.addEventListener('click', function () {
            userApprovalsModal.close();
        });
    }

    const adminUsersModal = document.getElementById('adminUsersModal');
    const openAdminUsersModal = document.getElementById('openAdminUsersModal');
    const closeAdminUsersModal = document.querySelector('.closeAdminUsersModal');

    if (openAdminUsersModal && adminUsersModal) {
        openAdminUsersModal.addEventListener('click', function () {
            adminUsersModal.showModal();
        });
    }
    if (closeAdminUsersModal && adminUsersModal) {
        closeAdminUsersModal.addEventListener('click', function () {
            adminUsersModal.close();
        });
    }

    // Dashboard: date filter toggles (Admin dashboard)
    function toggleDashDateFilters() {
        const dateType = document.getElementById('dashDateType')?.value || '';
        document.querySelectorAll('.dash-date-filter').forEach((el) => {
            el.style.display = 'none';
        });
        if (dateType === 'single') {
            const el = document.getElementById('dashSingleDate');
            if (el) el.style.display = 'flex';
        } else if (dateType === 'range') {
            const el1 = document.getElementById('dashDateRange');
            const el2 = document.getElementById('dashDateRangeTo');
            if (el1) el1.style.display = 'flex';
            if (el2) el2.style.display = 'flex';
        } else if (dateType === 'month') {
            const el = document.getElementById('dashMonthFilter');
            if (el) el.style.display = 'flex';
        }
    }

    // keep backward compatibility with inline onchange
    window.toggleDashDateFilters = toggleDashDateFilters;
    document.getElementById('dashDateType')?.addEventListener('change', toggleDashDateFilters);
    toggleDashDateFilters();

    // Add Record Dialog

    const addRecordButton = document.querySelector('.addRecordButton');
    const addRecordDialog = document.querySelector('.addRecordDialog');

    const locationCsv = `BARANGAY,MUNICIPALITY,PROVINCE
Betes,Aliaga,Nueva Ecija
Bibiclat,Aliaga,Nueva Ecija
Bucot,Aliaga,Nueva Ecija
La Purisima,Aliaga,Nueva Ecija
Magsaysay,Aliaga,Nueva Ecija
Macabucod,Aliaga,Nueva Ecija
Pantoc,Aliaga,Nueva Ecija
Poblacion Centro,Aliaga,Nueva Ecija
Poblacion East I,Aliaga,Nueva Ecija
Poblacion East II,Aliaga,Nueva Ecija
Poblacion West III,Aliaga,Nueva Ecija
Poblacion West IV,Aliaga,Nueva Ecija
San Carlos,Aliaga,Nueva Ecija
San Emiliano,Aliaga,Nueva Ecija
San Eustacio,Aliaga,Nueva Ecija
San Felipe Bata,Aliaga,Nueva Ecija
San Felipe Matanda,Aliaga,Nueva Ecija
San Juan,Aliaga,Nueva Ecija
San Pablo Bata,Aliaga,Nueva Ecija
San Pablo Matanda,Aliaga,Nueva Ecija
Santa Monica,Aliaga,Nueva Ecija
Santiago,Aliaga,Nueva Ecija
Santo Rosario,Aliaga,Nueva Ecija
Santo Tomas,Aliaga,Nueva Ecija
Sunson,Aliaga,Nueva Ecija
Umangan,Aliaga,Nueva Ecija
Antipolo,Bongabon,Nueva Ecija
Ariendo,Bongabon,Nueva Ecija
Bantug,Bongabon,Nueva Ecija
Calaanan,Bongabon,Nueva Ecija
Commercial,Bongabon,Nueva Ecija
Cruz,Bongabon,Nueva Ecija
Digmala,Bongabon,Nueva Ecija
Curva,Bongabon,Nueva Ecija
Kaingin,Bongabon,Nueva Ecija
Labi,Bongabon,Nueva Ecija
Larcon,Bongabon,Nueva Ecija
Lusok,Bongabon,Nueva Ecija
Macabaclay,Bongabon,Nueva Ecija
Magtanggol,Bongabon,Nueva Ecija
Mantile,Bongabon,Nueva Ecija
Olivete,Bongabon,Nueva Ecija
Palo Maria,Bongabon,Nueva Ecija
Pesa,Bongabon,Nueva Ecija
Rizal,Bongabon,Nueva Ecija
Sampalucan,Bongabon,Nueva Ecija
San Roque,Bongabon,Nueva Ecija
Santor,Bongabon,Nueva Ecija
Sinipit,Bongabon,Nueva Ecija
Sisilang na Ligaya,Bongabon,Nueva Ecija
Social,Bongabon,Nueva Ecija
Tugatug,Bongabon,Nueva Ecija
Tulay na Bato,Bongabon,Nueva Ecija
Vega,Bongabon,Nueva Ecija
Aduas Centro,City of Cabanatuan,Nueva Ecija
Bagong Sikat,City of Cabanatuan,Nueva Ecija
Bagong Buhay,City of Cabanatuan,Nueva Ecija
Bakero,City of Cabanatuan,Nueva Ecija
Bakod Bayan,City of Cabanatuan,Nueva Ecija
Balite,City of Cabanatuan,Nueva Ecija
Bangad,City of Cabanatuan,Nueva Ecija
Bantug Bulalo,City of Cabanatuan,Nueva Ecija
Bantug Norte,City of Cabanatuan,Nueva Ecija
Barlis,City of Cabanatuan,Nueva Ecija
Barrera District,City of Cabanatuan,Nueva Ecija
Bernardo District,City of Cabanatuan,Nueva Ecija
Bitas,City of Cabanatuan,Nueva Ecija
Bonifacio District,City of Cabanatuan,Nueva Ecija
Buliran,City of Cabanatuan,Nueva Ecija
Caalibangbangan,City of Cabanatuan,Nueva Ecija
Cabu,City of Cabanatuan,Nueva Ecija
Campo Tinio,City of Cabanatuan,Nueva Ecija
Kapitan Pepe,City of Cabanatuan,Nueva Ecija
Cinco-Cinco,City of Cabanatuan,Nueva Ecija
City Supermarket,City of Cabanatuan,Nueva Ecija
Caudillo,City of Cabanatuan,Nueva Ecija
Communal,City of Cabanatuan,Nueva Ecija
Cruz Roja,City of Cabanatuan,Nueva Ecija
Daang Sarile,City of Cabanatuan,Nueva Ecija
Dalampang,City of Cabanatuan,Nueva Ecija
Dicarma,City of Cabanatuan,Nueva Ecija
Dimasalang,City of Cabanatuan,Nueva Ecija
Dionisio S. Garcia,City of Cabanatuan,Nueva Ecija
Fatima,City of Cabanatuan,Nueva Ecija
General Luna,City of Cabanatuan,Nueva Ecija
Ibabao Bana,City of Cabanatuan,Nueva Ecija
Imelda District,City of Cabanatuan,Nueva Ecija
Isla,City of Cabanatuan,Nueva Ecija
Calawagan,City of Cabanatuan,Nueva Ecija
Kalikid Norte,City of Cabanatuan,Nueva Ecija
Kalikid Sur,City of Cabanatuan,Nueva Ecija
Lagare,City of Cabanatuan,Nueva Ecija
M. S. Garcia,City of Cabanatuan,Nueva Ecija
Mabini Extension,City of Cabanatuan,Nueva Ecija
Mabini Homesite,City of Cabanatuan,Nueva Ecija
Macatbong,City of Cabanatuan,Nueva Ecija
Magsaysay District,City of Cabanatuan,Nueva Ecija
Matadero,City of Cabanatuan,Nueva Ecija
Lourdes,City of Cabanatuan,Nueva Ecija
Mayapyap Norte,City of Cabanatuan,Nueva Ecija
Mayapyap Sur,City of Cabanatuan,Nueva Ecija
Melojavilla,City of Cabanatuan,Nueva Ecija
Obrero,City of Cabanatuan,Nueva Ecija
Padre Crisostomo,City of Cabanatuan,Nueva Ecija
Pagas,City of Cabanatuan,Nueva Ecija
Palagay,City of Cabanatuan,Nueva Ecija
Pamaldan,City of Cabanatuan,Nueva Ecija
Pangatian,City of Cabanatuan,Nueva Ecija
Patalac,City of Cabanatuan,Nueva Ecija
Polilio,City of Cabanatuan,Nueva Ecija
Pula,City of Cabanatuan,Nueva Ecija
Quezon District,City of Cabanatuan,Nueva Ecija
Rizdelis,City of Cabanatuan,Nueva Ecija
Samon,City of Cabanatuan,Nueva Ecija
San Isidro,City of Cabanatuan,Nueva Ecija
San Josef Norte,City of Cabanatuan,Nueva Ecija
San Josef Sur,City of Cabanatuan,Nueva Ecija
San Juan Pob.,City of Cabanatuan,Nueva Ecija
San Roque Norte,City of Cabanatuan,Nueva Ecija
San Roque Sur,City of Cabanatuan,Nueva Ecija
Sanbermicristi,City of Cabanatuan,Nueva Ecija
Sangitan,City of Cabanatuan,Nueva Ecija
Santa Arcadia,City of Cabanatuan,Nueva Ecija
Sumacab Norte,City of Cabanatuan,Nueva Ecija
Valdefuente,City of Cabanatuan,Nueva Ecija
Valle Cruz,City of Cabanatuan,Nueva Ecija
Vijandre District,City of Cabanatuan,Nueva Ecija
Villa Ofelia-Caridad,City of Cabanatuan,Nueva Ecija
Zulueta District,City of Cabanatuan,Nueva Ecija
Nabao,City of Cabanatuan,Nueva Ecija
Padre Burgos,City of Cabanatuan,Nueva Ecija
Talipapa,City of Cabanatuan,Nueva Ecija
Aduas Norte,City of Cabanatuan,Nueva Ecija
Aduas Sur,City of Cabanatuan,Nueva Ecija
"Hermogenes C. Concepcion, Sr.",City of Cabanatuan,Nueva Ecija
Sapang,City of Cabanatuan,Nueva Ecija
Sumacab Este,City of Cabanatuan,Nueva Ecija
Sumacab South,City of Cabanatuan,Nueva Ecija
Caridad,City of Cabanatuan,Nueva Ecija
Magsaysay South,City of Cabanatuan,Nueva Ecija
Maria Theresa,City of Cabanatuan,Nueva Ecija
Sangitan East,City of Cabanatuan,Nueva Ecija
Santo Niño,City of Cabanatuan,Nueva Ecija
Bagong Buhay,Cabiao,Nueva Ecija
Bagong Sikat,Cabiao,Nueva Ecija
Bagong Silang,Cabiao,Nueva Ecija
Concepcion,Cabiao,Nueva Ecija
Entablado,Cabiao,Nueva Ecija
Maligaya,Cabiao,Nueva Ecija
Natividad North,Cabiao,Nueva Ecija
Natividad South,Cabiao,Nueva Ecija
Palasinan,Cabiao,Nueva Ecija
San Antonio,Cabiao,Nueva Ecija
San Fernando Norte,Cabiao,Nueva Ecija
San Fernando Sur,Cabiao,Nueva Ecija
San Gregorio,Cabiao,Nueva Ecija
San Juan North,Cabiao,Nueva Ecija
San Juan South,Cabiao,Nueva Ecija
San Roque,Cabiao,Nueva Ecija
San Vicente,Cabiao,Nueva Ecija
Santa Rita,Cabiao,Nueva Ecija
Sinipit,Cabiao,Nueva Ecija
Polilio,Cabiao,Nueva Ecija
San Carlos,Cabiao,Nueva Ecija
Santa Isabel,Cabiao,Nueva Ecija
Santa Ines,Cabiao,Nueva Ecija
R.A.Padilla,Carranglan,Nueva Ecija
Bantug,Carranglan,Nueva Ecija
Bunga,Carranglan,Nueva Ecija
Burgos,Carranglan,Nueva Ecija
Capintalan,Carranglan,Nueva Ecija
Joson,Carranglan,Nueva Ecija
General Luna,Carranglan,Nueva Ecija
Minuli,Carranglan,Nueva Ecija
Piut,Carranglan,Nueva Ecija
Puncan,Carranglan,Nueva Ecija
Putlan,Carranglan,Nueva Ecija
Salazar,Carranglan,Nueva Ecija
San Agustin,Carranglan,Nueva Ecija
T. L. Padilla Pob.,Carranglan,Nueva Ecija
F. C. Otic Pob.,Carranglan,Nueva Ecija
D. L. Maglanoc Pob.,Carranglan,Nueva Ecija
G. S. Rosario Pob.,Carranglan,Nueva Ecija
Baloy,Cuyapo,Nueva Ecija
Bambanaba,Cuyapo,Nueva Ecija
Bantug,Cuyapo,Nueva Ecija
Bentigan,Cuyapo,Nueva Ecija
Bibiclat,Cuyapo,Nueva Ecija
Bonifacio,Cuyapo,Nueva Ecija
Bued,Cuyapo,Nueva Ecija
Bulala,Cuyapo,Nueva Ecija
Burgos,Cuyapo,Nueva Ecija
Cabileo,Cuyapo,Nueva Ecija
Cabatuan,Cuyapo,Nueva Ecija
Cacapasan,Cuyapo,Nueva Ecija
Calancuasan Norte,Cuyapo,Nueva Ecija
Calancuasan Sur,Cuyapo,Nueva Ecija
Colosboa,Cuyapo,Nueva Ecija
Columbitin,Cuyapo,Nueva Ecija
Curva,Cuyapo,Nueva Ecija
District I,Cuyapo,Nueva Ecija
District II,Cuyapo,Nueva Ecija
District IV,Cuyapo,Nueva Ecija
District V,Cuyapo,Nueva Ecija
District VI,Cuyapo,Nueva Ecija
District VII,Cuyapo,Nueva Ecija
District VIII,Cuyapo,Nueva Ecija
Landig,Cuyapo,Nueva Ecija
Latap,Cuyapo,Nueva Ecija
Loob,Cuyapo,Nueva Ecija
Luna,Cuyapo,Nueva Ecija
Malbeg-Patalan,Cuyapo,Nueva Ecija
Malineng,Cuyapo,Nueva Ecija
Matindeg,Cuyapo,Nueva Ecija
Maycaban,Cuyapo,Nueva Ecija
Nagcuralan,Cuyapo,Nueva Ecija
Nagmisahan,Cuyapo,Nueva Ecija
Paitan Norte,Cuyapo,Nueva Ecija
Paitan Sur,Cuyapo,Nueva Ecija
Piglisan,Cuyapo,Nueva Ecija
Pugo,Cuyapo,Nueva Ecija
Rizal,Cuyapo,Nueva Ecija
Sabit,Cuyapo,Nueva Ecija
Salagusog,Cuyapo,Nueva Ecija
San Antonio,Cuyapo,Nueva Ecija
San Jose,Cuyapo,Nueva Ecija
San Juan,Cuyapo,Nueva Ecija
Santa Clara,Cuyapo,Nueva Ecija
Santa Cruz,Cuyapo,Nueva Ecija
Simimbaan,Cuyapo,Nueva Ecija
Tagtagumbao,Cuyapo,Nueva Ecija
Tutuloy,Cuyapo,Nueva Ecija
Ungab,Cuyapo,Nueva Ecija
Villaflores,Cuyapo,Nueva Ecija
Bagong Sikat,Gabaldon,Nueva Ecija
Bagting,Gabaldon,Nueva Ecija
Bantug,Gabaldon,Nueva Ecija
Bitulok,Gabaldon,Nueva Ecija
Bugnan,Gabaldon,Nueva Ecija
Calabasa,Gabaldon,Nueva Ecija
Camachile,Gabaldon,Nueva Ecija
Cuyapa,Gabaldon,Nueva Ecija
Ligaya,Gabaldon,Nueva Ecija
Macasandal,Gabaldon,Nueva Ecija
Malinao,Gabaldon,Nueva Ecija
Pantoc,Gabaldon,Nueva Ecija
Pinamalisan,Gabaldon,Nueva Ecija
South Poblacion,Gabaldon,Nueva Ecija
Sawmill,Gabaldon,Nueva Ecija
Tagumpay,Gabaldon,Nueva Ecija
Bayanihan,City of Gapan,Nueva Ecija
Bulak,City of Gapan,Nueva Ecija
Kapalangan,City of Gapan,Nueva Ecija
Mahipon,City of Gapan,Nueva Ecija
Malimba,City of Gapan,Nueva Ecija
Mangino,City of Gapan,Nueva Ecija
Marelo,City of Gapan,Nueva Ecija
Pambuan,City of Gapan,Nueva Ecija
Parcutela,City of Gapan,Nueva Ecija
San Lorenzo,City of Gapan,Nueva Ecija
San Nicolas,City of Gapan,Nueva Ecija
San Roque,City of Gapan,Nueva Ecija
San Vicente,City of Gapan,Nueva Ecija
Santa Cruz,City of Gapan,Nueva Ecija
Santo Cristo Norte,City of Gapan,Nueva Ecija
Santo Cristo Sur,City of Gapan,Nueva Ecija
Santo Niño,City of Gapan,Nueva Ecija
Makabaclay,City of Gapan,Nueva Ecija
Balante,City of Gapan,Nueva Ecija
Bungo,City of Gapan,Nueva Ecija
Mabunga,City of Gapan,Nueva Ecija
Maburak,City of Gapan,Nueva Ecija
Puting Tubig,City of Gapan,Nueva Ecija
Balangkare Norte,General Mamerto Natividad,Nueva Ecija
Balangkare Sur,General Mamerto Natividad,Nueva Ecija
Balaring,General Mamerto Natividad,Nueva Ecija
Belen,General Mamerto Natividad,Nueva Ecija
Bravo,General Mamerto Natividad,Nueva Ecija
Burol,General Mamerto Natividad,Nueva Ecija
Kabulihan,General Mamerto Natividad,Nueva Ecija
Mag-asawang Sampaloc,General Mamerto Natividad,Nueva Ecija
Manarog,General Mamerto Natividad,Nueva Ecija
Mataas na Kahoy,General Mamerto Natividad,Nueva Ecija
Panacsac,General Mamerto Natividad,Nueva Ecija
Picaleon,General Mamerto Natividad,Nueva Ecija
Pinahan,General Mamerto Natividad,Nueva Ecija
Platero,General Mamerto Natividad,Nueva Ecija
Poblacion,General Mamerto Natividad,Nueva Ecija
Pula,General Mamerto Natividad,Nueva Ecija
Pulong Singkamas,General Mamerto Natividad,Nueva Ecija
Sapang Bato,General Mamerto Natividad,Nueva Ecija
Talabutab Norte,General Mamerto Natividad,Nueva Ecija
Talabutab Sur,General Mamerto Natividad,Nueva Ecija
Bago,General Tinio,Nueva Ecija
Concepcion,General Tinio,Nueva Ecija
Nazareth,General Tinio,Nueva Ecija
Padolina,General Tinio,Nueva Ecija
Pias,General Tinio,Nueva Ecija
San Pedro,General Tinio,Nueva Ecija
Poblacion East,General Tinio,Nueva Ecija
Poblacion West,General Tinio,Nueva Ecija
Rio Chico,General Tinio,Nueva Ecija
Poblacion Central,General Tinio,Nueva Ecija
Pulong Matong,General Tinio,Nueva Ecija
Sampaguita,General Tinio,Nueva Ecija
Palale,General Tinio,Nueva Ecija
Agcano,Guimba,Nueva Ecija
Ayos Lomboy,Guimba,Nueva Ecija
Bacayao,Guimba,Nueva Ecija
Bagong Barrio,Guimba,Nueva Ecija
Balbalino,Guimba,Nueva Ecija
Balingog East,Guimba,Nueva Ecija
Balingog West,Guimba,Nueva Ecija
Banitan,Guimba,Nueva Ecija
Bantug,Guimba,Nueva Ecija
Bulakid,Guimba,Nueva Ecija
Caballero,Guimba,Nueva Ecija
Cabaruan,Guimba,Nueva Ecija
Caingin Tabing Ilog,Guimba,Nueva Ecija
Calem,Guimba,Nueva Ecija
Camiing,Guimba,Nueva Ecija
Cardinal,Guimba,Nueva Ecija
Casongsong,Guimba,Nueva Ecija
Catimon,Guimba,Nueva Ecija
Cavite,Guimba,Nueva Ecija
Cawayan Bugtong,Guimba,Nueva Ecija
Consuelo,Guimba,Nueva Ecija
Culong,Guimba,Nueva Ecija
Escano,Guimba,Nueva Ecija
Faigal,Guimba,Nueva Ecija
Galvan,Guimba,Nueva Ecija
Guiset,Guimba,Nueva Ecija
Lamorito,Guimba,Nueva Ecija
Lennec,Guimba,Nueva Ecija
Macamias,Guimba,Nueva Ecija
Macapabellag,Guimba,Nueva Ecija
Macatcatuit,Guimba,Nueva Ecija
Manacsac,Guimba,Nueva Ecija
Manggang Marikit,Guimba,Nueva Ecija
Maturanoc,Guimba,Nueva Ecija
Maybubon,Guimba,Nueva Ecija
Naglabrahan,Guimba,Nueva Ecija
Nagpandayan,Guimba,Nueva Ecija
Narvacan I,Guimba,Nueva Ecija
Narvacan II,Guimba,Nueva Ecija
Pacac,Guimba,Nueva Ecija
Partida I,Guimba,Nueva Ecija
Partida II,Guimba,Nueva Ecija
Pasong Inchic,Guimba,Nueva Ecija
Saint John District,Guimba,Nueva Ecija
San Agustin,Guimba,Nueva Ecija
San Andres,Guimba,Nueva Ecija
San Bernardino,Guimba,Nueva Ecija
San Marcelino,Guimba,Nueva Ecija
San Miguel,Guimba,Nueva Ecija
San Rafael,Guimba,Nueva Ecija
San Roque,Guimba,Nueva Ecija
Santa Ana,Guimba,Nueva Ecija
Santa Cruz,Guimba,Nueva Ecija
Santa Lucia,Guimba,Nueva Ecija
Santa Veronica District,Guimba,Nueva Ecija
Santo Cristo District,Guimba,Nueva Ecija
Saranay District,Guimba,Nueva Ecija
Sinulatan,Guimba,Nueva Ecija
Subol,Guimba,Nueva Ecija
Tampac I,Guimba,Nueva Ecija
Tampac II & III,Guimba,Nueva Ecija
Triala,Guimba,Nueva Ecija
Yuson,Guimba,Nueva Ecija
Bunol,Guimba,Nueva Ecija
Calabasa,Jaen,Nueva Ecija
Dampulan,Jaen,Nueva Ecija
Hilera,Jaen,Nueva Ecija
Imbunia,Jaen,Nueva Ecija
Imelda Pob.,Jaen,Nueva Ecija
Lambakin,Jaen,Nueva Ecija
Langla,Jaen,Nueva Ecija
Magsalisi,Jaen,Nueva Ecija
Malabon-Kaingin,Jaen,Nueva Ecija
Marawa,Jaen,Nueva Ecija
Don Mariano Marcos,Jaen,Nueva Ecija
San Josef,Jaen,Nueva Ecija
Niyugan,Jaen,Nueva Ecija
Pamacpacan,Jaen,Nueva Ecija
Pakol,Jaen,Nueva Ecija
Pinanggaan,Jaen,Nueva Ecija
Ulanin-Pitak,Jaen,Nueva Ecija
Putlod,Jaen,Nueva Ecija
Ocampo-Rivera District,Jaen,Nueva Ecija
San Jose,Jaen,Nueva Ecija
San Pablo,Jaen,Nueva Ecija
San Roque,Jaen,Nueva Ecija
San Vicente,Jaen,Nueva Ecija
Santa Rita,Jaen,Nueva Ecija
Santo Tomas North,Jaen,Nueva Ecija
Santo Tomas South,Jaen,Nueva Ecija
Sapang,Jaen,Nueva Ecija
Barangay I,Laur,Nueva Ecija
Barangay II,Laur,Nueva Ecija
Barangay III,Laur,Nueva Ecija
Barangay IV,Laur,Nueva Ecija
Betania,Laur,Nueva Ecija
Canantong,Laur,Nueva Ecija
Nauzon,Laur,Nueva Ecija
Pangarulong,Laur,Nueva Ecija
Pinagbayanan,Laur,Nueva Ecija
Sagana,Laur,Nueva Ecija
San Fernando,Laur,Nueva Ecija
San Isidro,Laur,Nueva Ecija
San Josef,Laur,Nueva Ecija
San Juan,Laur,Nueva Ecija
San Vicente,Laur,Nueva Ecija
Siclong,Laur,Nueva Ecija
San Felipe,Laur,Nueva Ecija
Linao,Licab,Nueva Ecija
Poblacion Norte,Licab,Nueva Ecija
Poblacion Sur,Licab,Nueva Ecija
San Casimiro,Licab,Nueva Ecija
San Cristobal,Licab,Nueva Ecija
San Jose,Licab,Nueva Ecija
San Juan,Licab,Nueva Ecija
Santa Maria,Licab,Nueva Ecija
Tabing Ilog,Licab,Nueva Ecija
Villarosa,Licab,Nueva Ecija
Aquino,Licab,Nueva Ecija
A. Bonifacio,Llanera,Nueva Ecija
Caridad Norte,Llanera,Nueva Ecija
Caridad Sur,Llanera,Nueva Ecija
Casile,Llanera,Nueva Ecija
Florida Blanca,Llanera,Nueva Ecija
General Luna,Llanera,Nueva Ecija
General Ricarte,Llanera,Nueva Ecija
Gomez,Llanera,Nueva Ecija
Inanama,Llanera,Nueva Ecija
Ligaya,Llanera,Nueva Ecija
Mabini,Llanera,Nueva Ecija
Murcon,Llanera,Nueva Ecija
Plaridel,Llanera,Nueva Ecija
Bagumbayan,Llanera,Nueva Ecija
San Felipe,Llanera,Nueva Ecija
San Francisco,Llanera,Nueva Ecija
San Nicolas,Llanera,Nueva Ecija
San Vicente,Llanera,Nueva Ecija
Santa Barbara,Llanera,Nueva Ecija
Victoria,Llanera,Nueva Ecija
Villa Viniegas,Llanera,Nueva Ecija
Bosque,Llanera,Nueva Ecija
Agupalo Este,Lupao,Nueva Ecija
Agupalo Weste,Lupao,Nueva Ecija
Alalay Chica,Lupao,Nueva Ecija
Alalay Grande,Lupao,Nueva Ecija
J. U. Tienzo,Lupao,Nueva Ecija
Bagong Flores,Lupao,Nueva Ecija
Balbalungao,Lupao,Nueva Ecija
Burgos,Lupao,Nueva Ecija
Cordero,Lupao,Nueva Ecija
Mapangpang,Lupao,Nueva Ecija
Namulandayan,Lupao,Nueva Ecija
Parista,Lupao,Nueva Ecija
Poblacion East,Lupao,Nueva Ecija
Poblacion North,Lupao,Nueva Ecija
Poblacion South,Lupao,Nueva Ecija
Poblacion West,Lupao,Nueva Ecija
Salvacion I,Lupao,Nueva Ecija
Salvacion II,Lupao,Nueva Ecija
San Antonio Este,Lupao,Nueva Ecija
San Antonio Weste,Lupao,Nueva Ecija
San Isidro,Lupao,Nueva Ecija
San Pedro,Lupao,Nueva Ecija
San Roque,Lupao,Nueva Ecija
Santo Domingo,Lupao,Nueva Ecija
Bagong Sikat,Science City of Muñoz,Nueva Ecija
Balante,Science City of Muñoz,Nueva Ecija
Bantug,Science City of Muñoz,Nueva Ecija
Bical,Science City of Muñoz,Nueva Ecija
Cabisuculan,Science City of Muñoz,Nueva Ecija
Calabalabaan,Science City of Muñoz,Nueva Ecija
Calisitan,Science City of Muñoz,Nueva Ecija
Catalanacan,Science City of Muñoz,Nueva Ecija
Curva,Science City of Muñoz,Nueva Ecija
Franza,Science City of Muñoz,Nueva Ecija
Gabaldon,Science City of Muñoz,Nueva Ecija
Labney,Science City of Muñoz,Nueva Ecija
Licaong,Science City of Muñoz,Nueva Ecija
Linglingay,Science City of Muñoz,Nueva Ecija
Mangandingay,Science City of Muñoz,Nueva Ecija
Magtanggol,Science City of Muñoz,Nueva Ecija
Maligaya,Science City of Muñoz,Nueva Ecija
Mapangpang,Science City of Muñoz,Nueva Ecija
Maragol,Science City of Muñoz,Nueva Ecija
Matingkis,Science City of Muñoz,Nueva Ecija
Naglabrahan,Science City of Muñoz,Nueva Ecija
Palusapis,Science City of Muñoz,Nueva Ecija
Pandalla,Science City of Muñoz,Nueva Ecija
Poblacion East,Science City of Muñoz,Nueva Ecija
Poblacion North,Science City of Muñoz,Nueva Ecija
Poblacion South,Science City of Muñoz,Nueva Ecija
Poblacion West,Science City of Muñoz,Nueva Ecija
Rang-ayan,Science City of Muñoz,Nueva Ecija
Rizal,Science City of Muñoz,Nueva Ecija
San Andres,Science City of Muñoz,Nueva Ecija
San Antonio,Science City of Muñoz,Nueva Ecija
San Felipe,Science City of Muñoz,Nueva Ecija
Sapang Cawayan,Science City of Muñoz,Nueva Ecija
Villa Isla,Science City of Muñoz,Nueva Ecija
Villa Nati,Science City of Muñoz,Nueva Ecija
Villa Santos,Science City of Muñoz,Nueva Ecija
Villa Cuizon,Science City of Muñoz,Nueva Ecija
Alemania,Nampicuan,Nueva Ecija
Ambasador Alzate Village,Nampicuan,Nueva Ecija
Cabaducan East,Nampicuan,Nueva Ecija
Cabaducan West,Nampicuan,Nueva Ecija
Cabawangan,Nampicuan,Nueva Ecija
East Central Poblacion,Nampicuan,Nueva Ecija
Edy,Nampicuan,Nueva Ecija
Maeling,Nampicuan,Nueva Ecija
Mayantoc,Nampicuan,Nueva Ecija
Medico,Nampicuan,Nueva Ecija
Monic,Nampicuan,Nueva Ecija
North Poblacion,Nampicuan,Nueva Ecija
Northwest Poblacion,Nampicuan,Nueva Ecija
Estacion,Nampicuan,Nueva Ecija
West Poblacion,Nampicuan,Nueva Ecija
Recuerdo,Nampicuan,Nueva Ecija
South Central Poblacion,Nampicuan,Nueva Ecija
Southeast Poblacion,Nampicuan,Nueva Ecija
Southwest Poblacion,Nampicuan,Nueva Ecija
Tony,Nampicuan,Nueva Ecija
West Central Poblacion,Nampicuan,Nueva Ecija
Aulo,City of Palayan,Nueva Ecija
Bo. Militar,City of Palayan,Nueva Ecija
Ganaderia,City of Palayan,Nueva Ecija
Maligaya,City of Palayan,Nueva Ecija
Manacnac,City of Palayan,Nueva Ecija
Mapait,City of Palayan,Nueva Ecija
Marcos Village,City of Palayan,Nueva Ecija
Malate,City of Palayan,Nueva Ecija
Sapang Buho,City of Palayan,Nueva Ecija
Singalat,City of Palayan,Nueva Ecija
Atate,City of Palayan,Nueva Ecija
Caballero,City of Palayan,Nueva Ecija
Caimito,City of Palayan,Nueva Ecija
Doña Josefa,City of Palayan,Nueva Ecija
Imelda Valley,City of Palayan,Nueva Ecija
Langka,City of Palayan,Nueva Ecija
Santolan,City of Palayan,Nueva Ecija
Popolon Pagas,City of Palayan,Nueva Ecija
Bagong Buhay,City of Palayan,Nueva Ecija
Cadaclan,Pantabangan,Nueva Ecija
Cambitala,Pantabangan,Nueva Ecija
Conversion,Pantabangan,Nueva Ecija
Ganduz,Pantabangan,Nueva Ecija
Liberty,Pantabangan,Nueva Ecija
Malbang,Pantabangan,Nueva Ecija
Marikit,Pantabangan,Nueva Ecija
Napon-Napon,Pantabangan,Nueva Ecija
Poblacion East,Pantabangan,Nueva Ecija
Poblacion West,Pantabangan,Nueva Ecija
Sampaloc,Pantabangan,Nueva Ecija
San Juan,Pantabangan,Nueva Ecija
Villarica,Pantabangan,Nueva Ecija
Fatima,Pantabangan,Nueva Ecija
Callos,Peñaranda,Nueva Ecija
Las Piñas,Peñaranda,Nueva Ecija
Poblacion I,Peñaranda,Nueva Ecija
Poblacion II,Peñaranda,Nueva Ecija
Poblacion III,Peñaranda,Nueva Ecija
Poblacion IV,Peñaranda,Nueva Ecija
Santo Tomas,Peñaranda,Nueva Ecija
Sinasajan,Peñaranda,Nueva Ecija
San Josef,Peñaranda,Nueva Ecija
San Mariano,Peñaranda,Nueva Ecija
Bertese,Quezon,Nueva Ecija
Doña Lucia,Quezon,Nueva Ecija
Dulong Bayan,Quezon,Nueva Ecija
Ilog Baliwag,Quezon,Nueva Ecija
Barangay I,Quezon,Nueva Ecija
Barangay II,Quezon,Nueva Ecija
Pulong Bahay,Quezon,Nueva Ecija
San Alejandro,Quezon,Nueva Ecija
San Andres I,Quezon,Nueva Ecija
San Andres II,Quezon,Nueva Ecija
San Manuel,Quezon,Nueva Ecija
Santa Clara,Quezon,Nueva Ecija
Santa Rita,Quezon,Nueva Ecija
Santo Cristo,Quezon,Nueva Ecija
Santo Tomas Feria,Quezon,Nueva Ecija
San Miguel,Quezon,Nueva Ecija
Agbannawag,Rizal,Nueva Ecija
Bicos,Rizal,Nueva Ecija
Cabucbucan,Rizal,Nueva Ecija
Calaocan District,Rizal,Nueva Ecija
Canaan East,Rizal,Nueva Ecija
Canaan West,Rizal,Nueva Ecija
Casilagan,Rizal,Nueva Ecija
Aglipay,Rizal,Nueva Ecija
Del Pilar,Rizal,Nueva Ecija
Estrella,Rizal,Nueva Ecija
General Luna,Rizal,Nueva Ecija
Macapsing,Rizal,Nueva Ecija
Maligaya,Rizal,Nueva Ecija
Paco Roman,Rizal,Nueva Ecija
Pag-asa,Rizal,Nueva Ecija
Poblacion Central,Rizal,Nueva Ecija
Poblacion East,Rizal,Nueva Ecija
Poblacion Norte,Rizal,Nueva Ecija
Poblacion Sur,Rizal,Nueva Ecija
Poblacion West,Rizal,Nueva Ecija
Portal,Rizal,Nueva Ecija
San Esteban,Rizal,Nueva Ecija
Santa Monica,Rizal,Nueva Ecija
Villa Labrador,Rizal,Nueva Ecija
Villa Paraiso,Rizal,Nueva Ecija
San Gregorio,Rizal,Nueva Ecija
Buliran,San Antonio,Nueva Ecija
Cama Juan,San Antonio,Nueva Ecija
Julo,San Antonio,Nueva Ecija
Lawang Kupang,San Antonio,Nueva Ecija
Luyos,San Antonio,Nueva Ecija
Maugat,San Antonio,Nueva Ecija
Panabingan,San Antonio,Nueva Ecija
Papaya,San Antonio,Nueva Ecija
Poblacion,San Antonio,Nueva Ecija
San Francisco,San Antonio,Nueva Ecija
San Jose,San Antonio,Nueva Ecija
San Mariano,San Antonio,Nueva Ecija
Santa Cruz,San Antonio,Nueva Ecija
Santo Cristo,San Antonio,Nueva Ecija
Santa Barbara,San Antonio,Nueva Ecija
Tikiw,San Antonio,Nueva Ecija
Alua,San Isidro,Nueva Ecija
Calaba,San Isidro,Nueva Ecija
Malapit,San Isidro,Nueva Ecija
Mangga,San Isidro,Nueva Ecija
Poblacion,San Isidro,Nueva Ecija
Pulo,San Isidro,Nueva Ecija
San Roque,San Isidro,Nueva Ecija
Sto. Cristo,San Isidro,Nueva Ecija
Tabon,San Isidro,Nueva Ecija
A. Pascual,San Jose City,Nueva Ecija
Abar Ist,San Jose City,Nueva Ecija
Abar 2nd,San Jose City,Nueva Ecija
Bagong Sikat,San Jose City,Nueva Ecija
Caanawan,San Jose City,Nueva Ecija
Calaocan,San Jose City,Nueva Ecija
Camanacsacan,San Jose City,Nueva Ecija
Culaylay,San Jose City,Nueva Ecija
Dizol,San Jose City,Nueva Ecija
Kaliwanagan,San Jose City,Nueva Ecija
Kita-Kita,San Jose City,Nueva Ecija
Malasin,San Jose City,Nueva Ecija
Manicla,San Jose City,Nueva Ecija
Palestina,San Jose City,Nueva Ecija
Parang Mangga,San Jose City,Nueva Ecija
Villa Joson,San Jose City,Nueva Ecija
Pinili,San Jose City,Nueva Ecija
"Rafael Rueda, Sr. Pob.",San Jose City,Nueva Ecija
Ferdinand E. Marcos Pob.,San Jose City,Nueva Ecija
Canuto Ramos Pob.,San Jose City,Nueva Ecija
Raymundo Eugenio Pob.,San Jose City,Nueva Ecija
Crisanto Sanchez Pob.,San Jose City,Nueva Ecija
Porais,San Jose City,Nueva Ecija
San Agustin,San Jose City,Nueva Ecija
San Juan,San Jose City,Nueva Ecija
San Mauricio,San Jose City,Nueva Ecija
Santo Niño 1st,San Jose City,Nueva Ecija
Santo Niño 2nd,San Jose City,Nueva Ecija
Santo Tomas,San Jose City,Nueva Ecija
Sibut,San Jose City,Nueva Ecija
Sinipit Bubon,San Jose City,Nueva Ecija
Santo Niño 3rd,San Jose City,Nueva Ecija
Tabulac,San Jose City,Nueva Ecija
Tayabo,San Jose City,Nueva Ecija
Tondod,San Jose City,Nueva Ecija
Tulat,San Jose City,Nueva Ecija
Villa Floresca,San Jose City,Nueva Ecija
Villa Marina,San Jose City,Nueva Ecija
Bonifacio District,San Leonardo,Nueva Ecija
Burgos District,San Leonardo,Nueva Ecija
Castellano,San Leonardo,Nueva Ecija
Diversion,San Leonardo,Nueva Ecija
Magpapalayoc,San Leonardo,Nueva Ecija
Mallorca,San Leonardo,Nueva Ecija
Mambangnan,San Leonardo,Nueva Ecija
Nieves,San Leonardo,Nueva Ecija
San Bartolome,San Leonardo,Nueva Ecija
Rizal District,San Leonardo,Nueva Ecija
San Anton,San Leonardo,Nueva Ecija
San Roque,San Leonardo,Nueva Ecija
Tabuating,San Leonardo,Nueva Ecija
Tagumpay,San Leonardo,Nueva Ecija
Tambo Adorable,San Leonardo,Nueva Ecija
Cojuangco,Santa Rosa,Nueva Ecija
La Fuente,Santa Rosa,Nueva Ecija
Liwayway,Santa Rosa,Nueva Ecija
Malacañang,Santa Rosa,Nueva Ecija
Maliolio,Santa Rosa,Nueva Ecija
Mapalad,Santa Rosa,Nueva Ecija
Rizal,Santa Rosa,Nueva Ecija
Rajal Centro,Santa Rosa,Nueva Ecija
Rajal Norte,Santa Rosa,Nueva Ecija
Rajal Sur,Santa Rosa,Nueva Ecija
San Gregorio,Santa Rosa,Nueva Ecija
San Mariano,Santa Rosa,Nueva Ecija
San Pedro,Santa Rosa,Nueva Ecija
Santo Rosario,Santa Rosa,Nueva Ecija
Soledad,Santa Rosa,Nueva Ecija
Valenzuela,Santa Rosa,Nueva Ecija
Zamora,Santa Rosa,Nueva Ecija
Aguinaldo,Santa Rosa,Nueva Ecija
Berang,Santa Rosa,Nueva Ecija
Burgos,Santa Rosa,Nueva Ecija
Del Pilar,Santa Rosa,Nueva Ecija
Gomez,Santa Rosa,Nueva Ecija
Inspector,Santa Rosa,Nueva Ecija
Isla,Santa Rosa,Nueva Ecija
Lourdes,Santa Rosa,Nueva Ecija
Luna,Santa Rosa,Nueva Ecija
Mabini,Santa Rosa,Nueva Ecija
San Isidro,Santa Rosa,Nueva Ecija
San Josep,Santa Rosa,Nueva Ecija
Santa Teresita,Santa Rosa,Nueva Ecija
Sapsap,Santa Rosa,Nueva Ecija
Tagpos,Santa Rosa,Nueva Ecija
Tramo,Santa Rosa,Nueva Ecija
Baloc,Santo Domingo,Nueva Ecija
Buasao,Santo Domingo,Nueva Ecija
Burgos,Santo Domingo,Nueva Ecija
Cabugao,Santo Domingo,Nueva Ecija
Casulucan,Santo Domingo,Nueva Ecija
Comitang,Santo Domingo,Nueva Ecija
Concepcion,Santo Domingo,Nueva Ecija
Dolores,Santo Domingo,Nueva Ecija
General Luna,Santo Domingo,Nueva Ecija
Hulo,Santo Domingo,Nueva Ecija
Mabini,Santo Domingo,Nueva Ecija
Malasin,Santo Domingo,Nueva Ecija
Malayantoc,Santo Domingo,Nueva Ecija
Mambarao,Santo Domingo,Nueva Ecija
Poblacion,Santo Domingo,Nueva Ecija
Malaya,Santo Domingo,Nueva Ecija
Pulong Buli,Santo Domingo,Nueva Ecija
Sagaba,Santo Domingo,Nueva Ecija
San Agustin,Santo Domingo,Nueva Ecija
San Fabian,Santo Domingo,Nueva Ecija
San Francisco,Santo Domingo,Nueva Ecija
San Pascual,Santo Domingo,Nueva Ecija
Santa Rita,Santo Domingo,Nueva Ecija
Santo Rosario,Santo Domingo,Nueva Ecija
Andal Alino,Talavera,Nueva Ecija
Bagong Sikat,Talavera,Nueva Ecija
Bagong Silang,Talavera,Nueva Ecija
Bakal I,Talavera,Nueva Ecija
Bakal II,Talavera,Nueva Ecija
Bakal III,Talavera,Nueva Ecija
Baluga,Talavera,Nueva Ecija
Bantug,Talavera,Nueva Ecija
Bantug Hacienda,Talavera,Nueva Ecija
Bantug Hamog,Talavera,Nueva Ecija
Bugtong na Buli,Talavera,Nueva Ecija
Bulac,Talavera,Nueva Ecija
Burnay,Talavera,Nueva Ecija
Calipahan,Talavera,Nueva Ecija
Campos,Talavera,Nueva Ecija
Casulucan Este,Talavera,Nueva Ecija
Collado,Talavera,Nueva Ecija
Dimasalang Norte,Talavera,Nueva Ecija
Dimasalang Sur,Talavera,Nueva Ecija
Dinarayat,Talavera,Nueva Ecija
Esguerra District,Talavera,Nueva Ecija
Gulod,Talavera,Nueva Ecija
Homestead I,Talavera,Nueva Ecija
Homestead II,Talavera,Nueva Ecija
Cabubulaonan,Talavera,Nueva Ecija
Caaniplahan,Talavera,Nueva Ecija
Caputican,Talavera,Nueva Ecija
Kinalanguyan,Talavera,Nueva Ecija
La Torre,Talavera,Nueva Ecija
Lomboy,Talavera,Nueva Ecija
Mabuhay,Talavera,Nueva Ecija
Maestrang Kikay,Talavera,Nueva Ecija
Mamandil,Talavera,Nueva Ecija
Marcos District,Talavera,Nueva Ecija
Purok Matias,Talavera,Nueva Ecija
Matingkis,Talavera,Nueva Ecija
Minabuyoc,Talavera,Nueva Ecija
Pag-asa,Talavera,Nueva Ecija
Paludpod,Talavera,Nueva Ecija
Pantoc Bulac,Talavera,Nueva Ecija
Pinagpanaan,Talavera,Nueva Ecija
Poblacion Sur,Talavera,Nueva Ecija
Pula,Talavera,Nueva Ecija
Pulong San Miguel,Talavera,Nueva Ecija
Sampaloc,Talavera,Nueva Ecija
San Miguel na Munti,Talavera,Nueva Ecija
San Pascual,Talavera,Nueva Ecija
San Ricardo,Talavera,Nueva Ecija
Sibul,Talavera,Nueva Ecija
Sicsican Matanda,Talavera,Nueva Ecija
Tabacao,Talavera,Nueva Ecija
Tagaytay,Talavera,Nueva Ecija
Valle,Talavera,Nueva Ecija
Alula,Talugtug,Nueva Ecija
Baybayabas,Talugtug,Nueva Ecija
Buted,Talugtug,Nueva Ecija
Cabiangan,Talugtug,Nueva Ecija
Calisitan,Talugtug,Nueva Ecija
Cinense,Talugtug,Nueva Ecija
Culiat,Talugtug,Nueva Ecija
Maasin,Talugtug,Nueva Ecija
Magsaysay,Talugtug,Nueva Ecija
Mayamot I,Talugtug,Nueva Ecija
Mayamot II,Talugtug,Nueva Ecija
Nangabulan,Talugtug,Nueva Ecija
Osmeña,Talugtug,Nueva Ecija
Pangit(Fronda),Talugtug,Nueva Ecija
Patola,Talugtug,Nueva Ecija
Quezon,Talugtug,Nueva Ecija
Quirino,Talugtug,Nueva Ecija
Roxas,Talugtug,Nueva Ecija
Saguing,Talugtug,Nueva Ecija
Sampaloc,Talugtug,Nueva Ecija
Santa Catalina,Talugtug,Nueva Ecija
Santo Domingo,Talugtug,Nueva Ecija
Saringaya,Talugtug,Nueva Ecija
Saverona,Talugtug,Nueva Ecija
Tandoc,Talugtug,Nueva Ecija
Tibag,Talugtug,Nueva Ecija
Villa Rosario,Talugtug,Nueva Ecija
Villa Boado,Talugtug,Nueva Ecija
Villa Rosenda,Talugtug,Nueva Ecija
Batitang,Zaragoza,Nueva Ecija
Carmen,Zaragoza,Nueva Ecija
Concepcion,Zaragoza,Nueva Ecija
Del Pilar,Zaragoza,Nueva Ecija
General Luna,Zaragoza,Nueva Ecija
H. Romero,Zaragoza,Nueva Ecija
Macarse,Zaragoza,Nueva Ecija
Manaul,Zaragoza,Nueva Ecija
Mayamot,Zaragoza,Nueva Ecija
Pantoc,Zaragoza,Nueva Ecija
San Vicente,Zaragoza,Nueva Ecija
San Isidro,Zaragoza,Nueva Ecija
San Rafael,Zaragoza,Nueva Ecija
Santa Cruz,Zaragoza,Nueva Ecija
Santa Lucia Old,Zaragoza,Nueva Ecija
Santa Lucia Young,Zaragoza,Nueva Ecija
Santo Rosario Old,Zaragoza,Nueva Ecija
Santo Rosario Young,Zaragoza,Nueva Ecija
Valeriana,Zaragoza,Nueva Ecija
Barangay I,Baler,Aurora
Barangay II,Baler,Aurora
Barangay III,Baler,Aurora
Barangay IV,Baler,Aurora
Barangay V,Baler,Aurora
Buhangin,Baler,Aurora
Calabuanan,Baler,Aurora
Obligacion,Baler,Aurora
Pingit,Baler,Aurora
Reserva,Baler,Aurora
Sabang,Baler,Aurora
Suclayin,Baler,Aurora
Zabali,Baler,Aurora
Barangay 1,Casiguran,Aurora
Barangay 2,Casiguran,Aurora
Barangay 3,Casiguran,Aurora
Barangay 4,Casiguran,Aurora
Barangay 5,Casiguran,Aurora
Barangay 6,Casiguran,Aurora
Barangay 7,Casiguran,Aurora
Barangay 8,Casiguran,Aurora
Calabgan,Casiguran,Aurora
Calangcuasan,Casiguran,Aurora
Calantas,Casiguran,Aurora
Culat,Casiguran,Aurora
Dibet,Casiguran,Aurora
Esperanza,Casiguran,Aurora
Lual,Casiguran,Aurora
Marikit,Casiguran,Aurora
Tabas,Casiguran,Aurora
Tinib,Casiguran,Aurora
Bianoan,Casiguran,Aurora
Cozo,Casiguran,Aurora
Dibacong,Casiguran,Aurora
Ditinagyan,Casiguran,Aurora
Esteves,Casiguran,Aurora
San Ildefonso,Casiguran,Aurora
Diagyan,Dilasag,Aurora
Dicabasan,Dilasag,Aurora
Dilaguidi,Dilasag,Aurora
Dimaseset,Dilasag,Aurora
Diniog,Dilasag,Aurora
Lawang,Dilasag,Aurora
Maligaya,Dilasag,Aurora
Manggitahan,Dilasag,Aurora
Masagana,Dilasag,Aurora
Ura,Dilasag,Aurora
Esperanza,Dilasag,Aurora
Abuleg,Dinalungan,Aurora
Zone I,Dinalungan,Aurora
Zone II,Dinalungan,Aurora
Nipoo,Dinalungan,Aurora
Dibaraybay,Dinalungan,Aurora
Ditawini,Dinalungan,Aurora
Mapalad,Dinalungan,Aurora
Paleg,Dinalungan,Aurora
Simbahan,Dinalungan,Aurora
Aplaya,Dingalan,Aurora
Butas Na Bato,Dingalan,Aurora
Cabog,Dingalan,Aurora
Caragsacan,Dingalan,Aurora
Davildavilan,Dingalan,Aurora
Dikapanikian,Dingalan,Aurora
Ibona,Dingalan,Aurora
Paltic,Dingalan,Aurora
Poblacion,Dingalan,Aurora
Tanawan,Dingalan,Aurora
Umiray,Dingalan,Aurora
Bayabas,Dipaculao,Aurora
Buenavista,Dipaculao,Aurora
Borlongan,Dipaculao,Aurora
Calaocan,Dipaculao,Aurora
Dianed,Dipaculao,Aurora
Diarabasin,Dipaculao,Aurora
Dibutunan,Dipaculao,Aurora
Dimabuno,Dipaculao,Aurora
Dinadiawan,Dipaculao,Aurora
Ditale,Dipaculao,Aurora
Gupa,Dipaculao,Aurora
Ipil,Dipaculao,Aurora
Laboy,Dipaculao,Aurora
Lipit,Dipaculao,Aurora
Lobbot,Dipaculao,Aurora
Maligaya,Dipaculao,Aurora
Mijares,Dipaculao,Aurora
Mucdol,Dipaculao,Aurora
North Poblacion,Dipaculao,Aurora
Puangi,Dipaculao,Aurora
Salay,Dipaculao,Aurora
Sapangkawayan,Dipaculao,Aurora
South Poblacion,Dipaculao,Aurora
Toytoyan,Dipaculao,Aurora
Diamanen,Dipaculao,Aurora
Alcala,Maria Aurora,Aurora
Bagtu,Maria Aurora,Aurora
Bangco,Maria Aurora,Aurora
Bannawag,Maria Aurora,Aurora
Barangay I,Maria Aurora,Aurora
Barangay II,Maria Aurora,Aurora
Barangay III,Maria Aurora,Aurora
Barangay IV,Maria Aurora,Aurora
Baubo,Maria Aurora,Aurora
Bayanihan,Maria Aurora,Aurora
Bazal,Maria Aurora,Aurora
Cabituculan East,Maria Aurora,Aurora
Cabituculan West,Maria Aurora,Aurora
Debucao,Maria Aurora,Aurora
Decoliat,Maria Aurora,Aurora
Detailen,Maria Aurora,Aurora
Diaat,Maria Aurora,Aurora
Dialatman,Maria Aurora,Aurora
Diaman,Maria Aurora,Aurora
Dianawan,Maria Aurora,Aurora
Dikildit,Maria Aurora,Aurora
Dimanpudso,Maria Aurora,Aurora
Diome,Maria Aurora,Aurora
Estonilo,Maria Aurora,Aurora
Florida,Maria Aurora,Aurora
Galintuja,Maria Aurora,Aurora
Cadayacan,Maria Aurora,Aurora
Malasin,Maria Aurora,Aurora
Ponglo,Maria Aurora,Aurora
Quirino,Maria Aurora,Aurora
Ramada,Maria Aurora,Aurora
San Joaquin,Maria Aurora,Aurora
San Jose,Maria Aurora,Aurora
San Leonardo,Maria Aurora,Aurora
Santa Lucia,Maria Aurora,Aurora
Santo Tomas,Maria Aurora,Aurora
Suguit,Maria Aurora,Aurora
Villa Aurora,Maria Aurora,Aurora
Wenceslao,Maria Aurora,Aurora
San Juan,Maria Aurora,Aurora
Bacong,San Luis,Aurora
Barangay I,San Luis,Aurora
Barangay II,San Luis,Aurora
Barangay III,San Luis,Aurora
Barangay IV,San Luis,Aurora
Dibalo,San Luis,Aurora
Dibayabay,San Luis,Aurora
Dibut,San Luis,Aurora
Dikapinisan,San Luis,Aurora
Dimanayat,San Luis,Aurora
Diteki,San Luis,Aurora
Ditumabo,San Luis,Aurora
L. Pimentel,San Luis,Aurora
Nonong Senior,San Luis,Aurora
Real,San Luis,Aurora
San Isidro,San Luis,Aurora
San Jose,San Luis,Aurora
Zarah,San Luis,Aurora
Baguindoc,Anao,Tarlac
Bantog,Anao,Tarlac
Campos,Anao,Tarlac
Carmen,Anao,Tarlac
Casili,Anao,Tarlac
Don Ramon,Anao,Tarlac
Hernando,Anao,Tarlac
Poblacion,Anao,Tarlac
Rizal,Anao,Tarlac
San Francisco East,Anao,Tarlac
San Francisco West,Anao,Tarlac
San Jose North,Anao,Tarlac
San Jose South,Anao,Tarlac
San Juan,Anao,Tarlac
San Roque,Anao,Tarlac
Santo Domingo,Anao,Tarlac
Sinense,Anao,Tarlac
Suaverdez,Anao,Tarlac
Anupul,Bamban,Tarlac
Banaba,Bamban,Tarlac
Bangcu,Bamban,Tarlac
Culubasa,Bamban,Tarlac
Dela Cruz,Bamban,Tarlac
La Paz,Bamban,Tarlac
Lourdes,Bamban,Tarlac
Malonzo,Bamban,Tarlac
San Nicolas,Bamban,Tarlac
San Pedro,Bamban,Tarlac
San Rafael,Bamban,Tarlac
San Roque,Bamban,Tarlac
San Vicente,Bamban,Tarlac
Santo Niño,Bamban,Tarlac
Virgen de la Paz,Bamban,Tarlac
Anoling 1st,Camiling,Tarlac
Anoling 2nd,Camiling,Tarlac
Anoling 3rd,Camiling,Tarlac
Bacabac,Camiling,Tarlac
Bacsay,Camiling,Tarlac
Bancay 1st,Camiling,Tarlac
Bilad,Camiling,Tarlac
Birbira,Camiling,Tarlac
Bobon 1st,Camiling,Tarlac
Bobon 2nd,Camiling,Tarlac
Bobon Caarosipan,Camiling,Tarlac
Cabanabaan,Camiling,Tarlac
Cacamilingan Norte,Camiling,Tarlac
Cacamilingan Sur,Camiling,Tarlac
Caniag,Camiling,Tarlac
Carael,Camiling,Tarlac
Cayaoan,Camiling,Tarlac
Cayasan,Camiling,Tarlac
Florida,Camiling,Tarlac
Lasong,Camiling,Tarlac
Libueg,Camiling,Tarlac
Malacampa,Camiling,Tarlac
Manakem,Camiling,Tarlac
Manupeg,Camiling,Tarlac
Marawi,Camiling,Tarlac
Matubog,Camiling,Tarlac
Nagrambacan,Camiling,Tarlac
Nagserialam,Camiling,Tarlac
Palimbo Proper,Camiling,Tarlac
Palimbo-Caarosipan,Camiling,Tarlac
Pao 1st,Camiling,Tarlac
Pao 2nd,Camiling,Tarlac
Pao 3rd,Camiling,Tarlac
Papaac,Camiling,Tarlac
Pindangan 1st,Camiling,Tarlac
Pindangan 2nd,Camiling,Tarlac
Poblacion A,Camiling,Tarlac
Poblacion B,Camiling,Tarlac
Poblacion C,Camiling,Tarlac
Poblacion D,Camiling,Tarlac
Poblacion E,Camiling,Tarlac
Poblacion F,Camiling,Tarlac
Poblacion G,Camiling,Tarlac
Poblacion H,Camiling,Tarlac
Poblacion I,Camiling,Tarlac
Poblacion J,Camiling,Tarlac
Santa Maria,Camiling,Tarlac
Sawat,Camiling,Tarlac
Sinilian 1st,Camiling,Tarlac
Sinilian 2nd,Camiling,Tarlac
Sinilian 3rd,Camiling,Tarlac
Sinilian Cacalibosoan,Camiling,Tarlac
Sinulatan 1st,Camiling,Tarlac
Sinulatan 2nd,Camiling,Tarlac
Surgui 1st,Camiling,Tarlac
Surgui 2nd,Camiling,Tarlac
Surgui 3rd,Camiling,Tarlac
Tambugan,Camiling,Tarlac
Telbang,Camiling,Tarlac
Tuec,Camiling,Tarlac
Aranguren,Capas,Tarlac
Bueno,Capas,Tarlac
Cristo Rey,Capas,Tarlac
Cubcub,Capas,Tarlac
Cutcut 1st,Capas,Tarlac
Cutcut 2nd,Capas,Tarlac
Dolores,Capas,Tarlac
Estrada,Capas,Tarlac
Lawy,Capas,Tarlac
Manga,Capas,Tarlac
Manlapig,Capas,Tarlac
Maruglu,Capas,Tarlac
O'Donnell,Capas,Tarlac
Santa Juliana,Capas,Tarlac
Santa Lucia,Capas,Tarlac
Santa Rita,Capas,Tarlac
Santo Domingo 1st,Capas,Tarlac
Santo Domingo 2nd,Capas,Tarlac
Santo Rosario,Capas,Tarlac
Talaga,Capas,Tarlac
Alfonso,Concepcion,Tarlac
Balutu,Concepcion,Tarlac
Cafe,Concepcion,Tarlac
Calius Gueco,Concepcion,Tarlac
Caluluan,Concepcion,Tarlac
Castillo,Concepcion,Tarlac
Corazon de Jesus,Concepcion,Tarlac
Culatingan,Concepcion,Tarlac
Dungan,Concepcion,Tarlac
Dutung-A-Mataas,Concepcion,Tarlac
Green Village,Concepcion,Tarlac
Lilibangan,Concepcion,Tarlac
Mabilog,Concepcion,Tarlac
Magao,Concepcion,Tarlac
Malupa,Concepcion,Tarlac
Minane,Concepcion,Tarlac
Panalicsian Barbara,Concepcion,Tarlac
Pando,Concepcion,Tarlac
Parang,Concepcion,Tarlac
Parulung,Concepcion,Tarlac
Pitabunan,Concepcion,Tarlac
Plazang Toro,Concepcion,Tarlac
San Agustin,Concepcion,Tarlac
San Antonio,Concepcion,Tarlac
San Bartolome,Concepcion,Tarlac
San Francisco,Concepcion,Tarlac
San Isidro,Concepcion,Tarlac
San Jose,Concepcion,Tarlac
San Juan,Concepcion,Tarlac
San Martin,Concepcion,Tarlac
San Nicolas,Concepcion,Tarlac
San Nicolas Balas,Concepcion,Tarlac
San Vicente,Concepcion,Tarlac
Santa Cruz,Concepcion,Tarlac
Santa Maria,Concepcion,Tarlac
Santa Monica,Concepcion,Tarlac
Santa Rita,Concepcion,Tarlac
Santo Cristo,Concepcion,Tarlac
Santo Niño,Concepcion,Tarlac
Santo Rosario,Concepcion,Tarlac
Talimunduc Marimla,Concepcion,Tarlac
Telabanca,Concepcion,Tarlac
Tinang,Concepcion,Tarlac
Abagon,Gerona,Tarlac
Amacalan Sapang,Gerona,Tarlac
Apsayan,Gerona,Tarlac
Ayson,Gerona,Tarlac
Bawa,Gerona,Tarlac
Buenlag,Gerona,Tarlac
Bularit,Gerona,Tarlac
Calayaan,Gerona,Tarlac
Carbonel,Gerona,Tarlac
Cardona,Gerona,Tarlac
Caturay,Gerona,Tarlac
Danzo,Gerona,Tarlac
Dicolor,Gerona,Tarlac
Don Basilio,Gerona,Tarlac
Luna,Gerona,Tarlac
Mabini,Gerona,Tarlac
Magaspac,Gerona,Tarlac
Malayep,Gerona,Tarlac
Matapitap,Gerona,Tarlac
Matayumcab,Gerona,Tarlac
New Salem,Gerona,Tarlac
Oloybuaya,Gerona,Tarlac
Padapada,Gerona,Tarlac
Parsolingan,Gerona,Tarlac
Pinasling,Gerona,Tarlac
Plastado,Gerona,Tarlac
Poblacion 1,Gerona,Tarlac
Poblacion 2,Gerona,Tarlac
Poblacion 3,Gerona,Tarlac
Quezon,Gerona,Tarlac
Rizal,Gerona,Tarlac
Salapungan,Gerona,Tarlac
San Agustin,Gerona,Tarlac
San Antonio,Gerona,Tarlac
San Bartolome,Gerona,Tarlac
San Jose,Gerona,Tarlac
Santa Lucia,Gerona,Tarlac
Santiago,Gerona,Tarlac
Sembrano,Gerona,Tarlac
Singat,Gerona,Tarlac
Sulipa,Gerona,Tarlac
Tagumbao,Gerona,Tarlac
Tangcaran,Gerona,Tarlac
Villa Paz,Gerona,Tarlac
Balanoy,La Paz,Tarlac
Bantog-Caricutan,La Paz,Tarlac
Caramutan,La Paz,Tarlac
Colibangbang,La Paz,Tarlac
Caut,La Paz,Tarlac
Dinep,La Paz,Tarlac
Comillas Murillo,La Paz,Tarlac
Dumarais,La Paz,Tarlac
Guevarra,La Paz,Tarlac
Kapanikian,La Paz,Tarlac
La Purisima,La Paz,Tarlac
Lara,La Paz,Tarlac
Laungcupang,La Paz,Tarlac
Lomboy,La Paz,Tarlac
Macalong,La Paz,Tarlac
Matayumtayum,La Paz,Tarlac
Mayang,La Paz,Tarlac
Motrico,La Paz,Tarlac
Paludpud,La Paz,Tarlac
Rizal,La Paz,Tarlac
San Isidro,La Paz,Tarlac
San Roque,La Paz,Tarlac
Sierra,La Paz,Tarlac

Ambalingit,Mayantoc,Tarlac
Baybayaoas,Mayantoc,Tarlac
Bigbiga,Mayantoc,Tarlac
Binbinaca,Mayantoc,Tarlac
Calabtangan,Mayantoc,Tarlac
Caocaoayan,Mayantoc,Tarlac
Carabaoan,Mayantoc,Tarlac
Cubcub,Mayantoc,Tarlac
Gayonggayong,Mayantoc,Tarlac
Gossood,Mayantoc,Tarlac
Labney,Mayantoc,Tarlac
Mamonit,Mayantoc,Tarlac
Maniniog,Mayantoc,Tarlac
Mapandan,Mayantoc,Tarlac
Nambalan,Mayantoc,Tarlac
Pedro L. Quines,Mayantoc,Tarlac
Pitombayog,Mayantoc,Tarlac
Poblacion Norte,Mayantoc,Tarlac
Poblacion Sur,Mayantoc,Tarlac
Rotrottooc,Mayantoc,Tarlac
San Bartolome,Mayantoc,Tarlac
San Jose,Mayantoc,Tarlac
Taldiapan,Mayantoc,Tarlac
Tangcarang,Mayantoc,Tarlac
Ablang-Sapang,Moncada,Tarlac
Aringin,Moncada,Tarlac
Atencio,Moncada,Tarlac
Banaoang East,Moncada,Tarlac
Banaoang West,Moncada,Tarlac
Baquero Norte,Moncada,Tarlac
Baquero Sur,Moncada,Tarlac
Calamay,Moncada,Tarlac
Calapan,Moncada,Tarlac
Camangaan East,Moncada,Tarlac
Camangaan West,Moncada,Tarlac
Camposanto 1-Norte,Moncada,Tarlac
Camposanto 1-Sur,Moncada,Tarlac
Camposanto 2,Moncada,Tarlac
Capaoayan,Moncada,Tarlac
Lapsing,Moncada,Tarlac
Mabini,Moncada,Tarlac
Maluac,Moncada,Tarlac
Poblacion 1,Moncada,Tarlac
Poblacion 2,Moncada,Tarlac
Poblacion 3,Moncada,Tarlac
Poblacion 4,Moncada,Tarlac
Rizal,Moncada,Tarlac
San Juan,Moncada,Tarlac
San Julian,Moncada,Tarlac
San Leon,Moncada,Tarlac
San Pedro,Moncada,Tarlac
San Roque,Moncada,Tarlac
Santa Lucia East,Moncada,Tarlac
Santa Lucia West,Moncada,Tarlac
Santa Maria,Moncada,Tarlac
Santa Monica,Moncada,Tarlac
Tolega Norte,Moncada,Tarlac
Tolega Sur,Moncada,Tarlac
Tubectubang,Moncada,Tarlac
Villa,Moncada,Tarlac
Abogado,Paniqui,Tarlac
Acocolao,Paniqui,Tarlac
Aduas,Paniqui,Tarlac
Apulid,Paniqui,Tarlac
Balaoang,Paniqui,Tarlac
Barang,Paniqui,Tarlac
Brillante,Paniqui,Tarlac
Burgos,Paniqui,Tarlac
Cabayaoasan,Paniqui,Tarlac
Canan,Paniqui,Tarlac
Carino,Paniqui,Tarlac
Cayanga,Paniqui,Tarlac
Colibangbang,Paniqui,Tarlac
Coral,Paniqui,Tarlac
Dapdap,Paniqui,Tarlac
Estacion,Paniqui,Tarlac
Mabilang,Paniqui,Tarlac
Manaois,Paniqui,Tarlac
Matalapitap,Paniqui,Tarlac
Nagmisaan,Paniqui,Tarlac
Nancamarinan,Paniqui,Tarlac
Nipaco,Paniqui,Tarlac
Patalan,Paniqui,Tarlac
Poblacion Norte,Paniqui,Tarlac
Poblacion Sur,Paniqui,Tarlac
Rang-ayan,Paniqui,Tarlac
Salumague,Paniqui,Tarlac
Samput,Paniqui,Tarlac
San Carlos,Paniqui,Tarlac
San Isidro,Paniqui,Tarlac
San Juan de Milla,Paniqui,Tarlac
Santa Ines,Paniqui,Tarlac
Sinigpit,Paniqui,Tarlac
Tablang,Paniqui,Tarlac
Ventenilla,Paniqui,Tarlac
Balite,Pura,Tarlac
Buenavista,Pura,Tarlac
Cadanglaan,Pura,Tarlac
Estipona,Pura,Tarlac
Linao,Pura,Tarlac
Maasin,Pura,Tarlac
Matindeg,Pura,Tarlac
Maungib,Pura,Tarlac
Naya,Pura,Tarlac
Nilasin 1st,Pura,Tarlac
Nilasin 2nd,Pura,Tarlac
Poblacion 1,Pura,Tarlac
Poblacion 2,Pura,Tarlac
Poblacion 3,Pura,Tarlac,
Poroc,Pura,Tarlac
Singat,Pura,Tarlac
Coral-Iloco,Ramos,Tarlac
Guiteb,Ramos,Tarlac
Pance,Ramos,Tarlac
Poblacion Center,Ramos,Tarlac
Poblacion North,Ramos,Tarlac
Poblacion South,Ramos,Tarlac
San Juan,Ramos,Tarlac
San Raymundo,Ramos,Tarlac
Toledo,Ramos,Tarlac
Balloc,San Clemente,Tarlac
Bamban,San Clemente,Tarlac
Casipo,San Clemente,Tarlac
Catagudingan,San Clemente,Tarlac
Daldalayap,San Clemente,Tarlac
Doclong 1,San Clemente,Tarlac
Doclong 2,San Clemente,Tarlac
Maasin,San Clemente,Tarlac
Nagsabaran,San Clemente,Tarlac
Pit-ao,San Clemente,Tarlac
Poblacion Norte	,San Clemente,Tarlac
Poblacion Sur,San Clemente,Tarlac
Burgos,San Jose,Tarlac
David,San Jose,Tarlac
Iba,San Jose,Tarlac
Labney,San Jose,Tarlac
Lawacamulag,San Jose,Tarlac
Lubigan,San Jose,Tarlac
Maamot,San Jose,Tarlac
Mababanaba,San Jose,Tarlac
Moriones,San Jose,Tarlac
Pao,San Jose,Tarlac
San Juan de Valdez,San Jose,Tarlac
Sula,San Jose,Tarlac
Villa Aglipay,San Jose,Tarlac
Colubot,San Manuel,Tarlac
Lanat,San Manuel,Tarlac
Legaspi,San Manuel,Tarlac
Mangandingay,San Manuel,Tarlac
Matarannoc,San Manuel,Tarlac
Pacpaco,San Manuel,Tarlac
Poblacion,San Manuel,Tarlac
Salcedo,San Manuel,Tarlac
San Agustin,San Manuel,Tarlac
San Felipe,San Manuel,Tarlac
San Jacinto,San Manuel,Tarlac
San Miguel,San Manuel,Tarlac
San Narciso,San Manuel,Tarlac
San Vicente,San Manuel,Tarlac
Santa Maria,San Manuel,Tarlac
Baldios,Santa Ignacia,Tarlac
Botbotones,Santa Ignacia,Tarlac
Caanamongan,Santa Ignacia,Tarlac
Cabaruan,Santa Ignacia,Tarlac
Cabugbugan,Santa Ignacia,Tarlac
Caduldulaoan,Santa Ignacia,Tarlac
Calipayan,Santa Ignacia,Tarlac
Macaguing,Santa Ignacia,Tarlac
Nambalan,Santa Ignacia,Tarlac
Padapada,Santa Ignacia,Tarlac
Pilpila,Santa Ignacia,Tarlac
Pinpinas,Santa Ignacia,Tarlac
Poblacion East,Santa Ignacia,Tarlac
Poblacion West,Santa Ignacia,Tarlac
Pugo-Cecilio,Santa Ignacia,Tarlac
San Francisco,Santa Ignacia,Tarlac
San Sotero,Santa Ignacia,Tarlac
San Vicente,Santa Ignacia,Tarlac
Santa Ines Centro,Santa Ignacia,Tarlac
Santa Ines East,Santa Ignacia,Tarlac
Santa Ines West,Santa Ignacia,Tarlac
Taguiporo,Santa Ignacia,Tarlac
Timmaguab,Santa Ignacia,Tarlac
Vargas,Santa Ignacia,Tarlac
Aguso,City of Tarlac,Tarlac
Alvindia Segundo,City of Tarlac,Tarlac
Amucao,City of Tarlac,Tarlac
Armenia,City of Tarlac,Tarlac
Asturias,City of Tarlac,Tarlac
Atioc,City of Tarlac,Tarlac
Balanti,City of Tarlac,Tarlac
Balete,City of Tarlac,Tarlac
Balibago I,City of Tarlac,Tarlac
Balibago II,City of Tarlac,Tarlac
Balingcanaway,City of Tarlac,Tarlac
Banaba,City of Tarlac,Tarlac
Bantog,City of Tarlac,Tarlac
Baras-baras,City of Tarlac,Tarlac
Batang-batang,City of Tarlac,Tarlac
Binauganan,City of Tarlac,Tarlac
Bora,City of Tarlac,Tarlac
Buenavista,City of Tarlac,Tarlac
Buhilit,City of Tarlac,Tarlac
Burot,City of Tarlac,Tarlac
Calingcuan,City of Tarlac,Tarlac
Capehan,City of Tarlac,Tarlac
Carangian,City of Tarlac,Tarlac
Care,City of Tarlac,Tarlac
Central,City of Tarlac,Tarlac
Culipat,City of Tarlac,Tarlac
Cut-cut I,City of Tarlac,Tarlac
Cut-cut II,City of Tarlac,Tarlac
Dalayap,City of Tarlac,Tarlac
Dela Paz,City of Tarlac,Tarlac
Dolores,City of Tarlac,Tarlac
Laoang,City of Tarlac,Tarlac
Ligtasan,City of Tarlac,Tarlac
Lourdes,City of Tarlac,Tarlac
Mabini,City of Tarlac,Tarlac
Maligaya,City of Tarlac,Tarlac
Maliwalo,City of Tarlac,Tarlac
Mapalad,City of Tarlac,Tarlac
Matadero,City of Tarlac,Tarlac
Matatalaib,City of Tarlac,Tarlac
Paraiso,City of Tarlac,Tarlac
Poblacion,City of Tarlac,Tarlac
Salapungan,City of Tarlac,Tarlac
San Carlos,City of Tarlac,Tarlac
San Francisco,City of Tarlac,Tarlac
San Isidro,City of Tarlac,Tarlac
San Jose,City of Tarlac,Tarlac
San Jose de Urquico,City of Tarlac,Tarlac
San Juan de Mata,City of Tarlac,Tarlac
San Luis,City of Tarlac,Tarlac
San Manuel,City of Tarlac,Tarlac
San Miguel,City of Tarlac,Tarlac
San Nicolas,City of Tarlac,Tarlac
San Pablo,City of Tarlac,Tarlac
San Pascual,City of Tarlac,Tarlac
San Rafael,City of Tarlac,Tarlac
San Roque,City of Tarlac,Tarlac
San Sebastian,City of Tarlac,Tarlac
San Vicente,City of Tarlac,Tarlac
Santa Cruz,City of Tarlac,Tarlac
Santa Maria,City of Tarlac,Tarlac
Santo Cristo,City of Tarlac,Tarlac
Santo Domingo,City of Tarlac,Tarlac
Santo Niño,City of Tarlac,Tarlac
Sapang Maragul,City of Tarlac,Tarlac
Sapang Tagalog,City of Tarlac,Tarlac
Sepung Calzada,City of Tarlac,Tarlac
Sinait,City of Tarlac,Tarlac
Suizo,City of Tarlac,Tarlac
Tariji,City of Tarlac,Tarlac
Tibag,City of Tarlac,Tarlac
Tibagan,City of Tarlac,Tarlac
Trinidad,City of Tarlac,Tarlac
Ungot,City of Tarlac,Tarlac
Villa Bacolor,City of Tarlac,Tarlac

Baculong,Victoria,Tarlac
Balayang,Victoria,Tarlac
Balbaloto,Victoria,Tarlac
Bangar,Victoria,Tarlac
Bantog,Victoria,Tarlac
Batangbatang,Victoria,Tarlac
Bulo,Victoria,Tarlac
Cabuluan,Victoria,Tarlac
Calibungan,Victoria,Tarlac
Canarem,Victoria,Tarlac
Cruz,Victoria,Tarlac
Lalapac,Victoria,Tarlac
Maluid,Victoria,Tarlac
Mangolago,Victoria,Tarlac
Masalasa,Victoria,Tarlac
Palacpalac,Victoria,Tarlac
San Agustin,Victoria,Tarlac
San Andres,Victoria,Tarlac
San Fernando,Victoria,Tarlac
San Francisco,Victoria,Tarlac
San Gavino,Victoria,Tarlac
San Jacinto,Victoria,Tarlac
San Nicolas,Victoria,Tarlac
San Vicente,Victoria,Tarlac
Santa Barbara,Victoria,Tarlac
Santa Lucia,Victoria,Tarlac`;

    function parseCsvLine(line) {
        const values = [];
        let current = '';
        let insideQuotes = false;

        for (let i = 0; i < line.length; i++) {
            const char = line[i];
            if (char === '"') {
                if (insideQuotes && line[i + 1] === '"') {
                    current += '"';
                    i++;
                } else {
                    insideQuotes = !insideQuotes;
                }
            } else if (char === ',' && !insideQuotes) {
                values.push(current);
                current = '';
            } else {
                current += char;
            }
        }

        values.push(current);
        return values;
    }

    function parseLocationData(csv) {
        const data = {};
        const lines = csv.split(/\r?\n/).filter(line => line.trim().length > 0);

        for (let i = 1; i < lines.length; i++) {
            const [barangay, municipality, province] = parseCsvLine(lines[i]);
            if (!province || !municipality || !barangay) {
                continue;
            }

            if (!data[province]) {
                data[province] = {};
            }
            if (!data[province][municipality]) {
                data[province][municipality] = [];
            }
            if (!data[province][municipality].includes(barangay)) {
                data[province][municipality].push(barangay);
            }
        }

        for (const province of Object.keys(data)) {
            for (const municipality of Object.keys(data[province])) {
                data[province][municipality].sort((a, b) => a.localeCompare(b, 'en', { sensitivity: 'base' }));
            }
        }

        return data;
    }

    const locationData = parseLocationData(locationCsv);

    function populateSelect(selectElement, options, placeholder) {
        selectElement.innerHTML = '';
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = placeholder;
        selectElement.appendChild(defaultOption);

        options.forEach(option => {
            const optionItem = document.createElement('option');
            optionItem.value = option;
            optionItem.textContent = option;
            selectElement.appendChild(optionItem);
        });
    }

    function updateMunicipalities(provinceSelect, municipalitySelect, barangaySelect) {
        if (!provinceSelect.value) {
            populateSelect(municipalitySelect, [], 'Select Municipality');
            municipalitySelect.disabled = true;
            populateSelect(barangaySelect, [], 'Select Barangay');
            barangaySelect.disabled = true;
            return;
        }

        const municipalities = Object.keys(locationData[provinceSelect.value] || {});
        populateSelect(municipalitySelect, municipalities, 'Select Municipality');
        municipalitySelect.disabled = false;
        populateSelect(barangaySelect, [], 'Select Barangay');
        barangaySelect.disabled = true;
    }

    function updateBarangays(provinceSelect, municipalitySelect, barangaySelect) {
        if (!provinceSelect.value || !municipalitySelect.value) {
            populateSelect(barangaySelect, [], 'Select Barangay');
            barangaySelect.disabled = true;
            return;
        }

        const barangays = locationData[provinceSelect.value]?.[municipalitySelect.value] || [];
        populateSelect(barangaySelect, barangays, 'Select Barangay');
        barangaySelect.disabled = false;
    }

    function setHiddenAddress(provinceSelect, municipalitySelect, barangaySelect, hiddenAddressInput) {
        if (!hiddenAddressInput) {
            return;
        }

        hiddenAddressInput.value = [barangaySelect.value, municipalitySelect.value, provinceSelect.value]
            .filter(Boolean)
            .join(', ');
    }

    if (addRecordButton && addRecordDialog) {
        addRecordButton.addEventListener('click', function () {
            addRecordDialog.showModal();
            setTimeout(function() {
                var firstInput = addRecordDialog.querySelector('input:not([type="hidden"]):not([type="checkbox"])');
                if (firstInput) firstInput.focus();
            }, 100);
        });
    }

    const closeAddRecordModal = document.querySelector('.closeAddRecordModal');
    const addProvince = document.getElementById('province');
    const addMunicipality = document.getElementById('municipality');
    const addBarangay = document.getElementById('barangay');
    const addRecordAddress = document.getElementById('addRecordAddress');
    const addRecordForm = document.querySelector('.addRecordDialog form');

    if (closeAddRecordModal && addRecordDialog) {
        closeAddRecordModal.addEventListener('click', function () {
            addRecordDialog.close();
        });
    }

    if (addProvince && addMunicipality && addBarangay) {
        addProvince.addEventListener('change', function () {
            updateMunicipalities(addProvince, addMunicipality, addBarangay);
        });

        addMunicipality.addEventListener('change', function () {
            updateBarangays(addProvince, addMunicipality, addBarangay);
        });
    }

    if (addRecordForm) {
        addRecordForm.addEventListener('submit', function () {
            setHiddenAddress(addProvince, addMunicipality, addBarangay, addRecordAddress);
            
            // Save location values to localStorage for Officer of the Day
            if (addProvince && addMunicipality && addBarangay) {
                localStorage.setItem('od_province', addProvince.value);
                localStorage.setItem('od_municipality', addMunicipality.value);
                localStorage.setItem('od_barangay', addBarangay.value);
            }
            
            // Save location values to localStorage for Email
            if (addProvince && addMunicipality && addBarangay) {
                localStorage.setItem('email_province', addProvince.value);
                localStorage.setItem('email_municipality', addMunicipality.value);
                localStorage.setItem('email_barangay', addBarangay.value);
            }
        });
    }

    // Restore location values on page load (after successful submission)
    function restoreLocationValues() {
        if (addProvince && addMunicipality && addBarangay) {
            const savedProvince = localStorage.getItem('od_province');
            const savedMunicipality = localStorage.getItem('od_municipality');
            const savedBarangay = localStorage.getItem('od_barangay');
            
            if (savedProvince) {
                addProvince.value = savedProvince;
                addMunicipality.disabled = false;
                addMunicipality.classList.remove('bg-gray-50');
                addMunicipality.classList.add('bg-white');
                
                const event = new Event('change');
                addProvince.dispatchEvent(event);
                
                setTimeout(function() {
                    if (savedMunicipality) {
                        addMunicipality.value = savedMunicipality;
                        addBarangay.disabled = false;
                        addBarangay.classList.remove('bg-gray-50');
                        addBarangay.classList.add('bg-white');
                        
                        const municipalityEvent = new Event('change');
                        addMunicipality.dispatchEvent(municipalityEvent);
                        
                        setTimeout(function() {
                            if (savedBarangay) {
                                addBarangay.value = savedBarangay;
                            }
                        }, 100);
                    }
                }, 100);
            }
        }
    }
    
    restoreLocationValues();

    // Restore location values for Email channel
    function restoreEmailLocationValues() {
        if (addProvince && addMunicipality && addBarangay) {
            const savedProvince = localStorage.getItem('email_province');
            const savedMunicipality = localStorage.getItem('email_municipality');
            const savedBarangay = localStorage.getItem('email_barangay');
            
            if (savedProvince) {
                addProvince.value = savedProvince;
                addMunicipality.disabled = false;
                addMunicipality.classList.remove('bg-gray-50');
                addMunicipality.classList.add('bg-white');
                
                const event = new Event('change');
                addProvince.dispatchEvent(event);
                
                setTimeout(function() {
                    if (savedMunicipality) {
                        addMunicipality.value = savedMunicipality;
                        addBarangay.disabled = false;
                        addBarangay.classList.remove('bg-gray-50');
                        addBarangay.classList.add('bg-white');
                        
                        const municipalityEvent = new Event('change');
                        addMunicipality.dispatchEvent(municipalityEvent);
                        
                        setTimeout(function() {
                            if (savedBarangay) {
                                addBarangay.value = savedBarangay;
                            }
                        }, 100);
                    }
                }, 100);
            }
        }
    }
    
    restoreEmailLocationValues();

    // Edit Record Dialog

    function setSelectValueOrAddOption(selectEl, rawValue) {
        if (!selectEl || rawValue == null) {
            return;
        }
        const v = String(rawValue).trim();
        if (v === '') {
            return;
        }
        selectEl.value = v;
        if (selectEl.value !== v) {
            const opt = document.createElement('option');
            opt.value = v;
            opt.textContent = v;
            selectEl.appendChild(opt);
            selectEl.value = v;
        }
    }

    function openRecordEditDialog(button) {
        // Find the closest dialog/parent with the edit form
        const dialog = button.closest('dialog');
        let editForm = null;
        
        if (dialog) {
            // Find the edit form within the dialog
            editForm = dialog.querySelector('#recordEditForm');
        } else {
            // Fallback to document-wide search
            editForm = document.getElementById('recordEditForm');
        }
        
        if (!editForm) {
            return;
        }
        // Do not use document as form root: the admin NL area has filter inputs (e.g. name="farmerName")
        // that would be matched first and leave the real edit modal fields empty.
        const formRoot = editForm;
        // HTML lowercases data-* names; use dataset (kebab-case in markup → camelCase here)
        const ds = button.dataset;
        const id = button.getAttribute('data-id') || ds.id;
        const farmerName = ds.farmerName != null ? String(ds.farmerName) : '';
        const province = ds.province != null ? String(ds.province).trim() : '';
        const municipality = ds.municipality != null ? String(ds.municipality).trim() : '';
        const barangay = ds.barangay != null ? String(ds.barangay).trim() : '';
        const address = ds.address != null ? String(ds.address) : '';
        const program = ds.program != null ? String(ds.program) : '';
        const line = ds.line != null ? String(ds.line) : '';
        const causeOfDamage = ds.causeOfDamage != null ? String(ds.causeOfDamage) : '';
        const modeOfPayment = ds.modeOfPayment != null ? String(ds.modeOfPayment) : '';
        const accounts = ds.accounts != null ? String(ds.accounts) : '';
        const fbPageUrl = ds.fbPageUrl != null ? String(ds.fbPageUrl) : '';
        const dateOccurrence = ds.dateOccurrence != null ? String(ds.dateOccurrence) : '';
        const dateReceived = ds.dateReceived != null ? String(ds.dateReceived) : '';
        const remarks = ds.remarks != null ? String(ds.remarks) : '';
        const source = ds.source != null ? String(ds.source) : '';
        const transmittalNumber = ds.transmittalNumber != null ? String(ds.transmittalNumber) : '';
        const adminTransmittalNumber = ds.adminTransmittalNumber != null ? String(ds.adminTransmittalNumber) : '';

        editForm.action = id ? `/records/${id}` : editForm.getAttribute('action') || '';

        const farmerNameInput = formRoot.querySelector('input[name="farmerName"]');
        if (farmerNameInput) farmerNameInput.value = farmerName;

        const editProvince = document.getElementById('editProvince');
        const editMunicipality = document.getElementById('editMunicipality');
        const editBarangay = document.getElementById('editBarangay');
        const editRecordAddress = document.getElementById('editRecordAddress');

        if (editProvince && editMunicipality && editBarangay) {
            if (!province && address) {
                const addressParts = address.split(',').map((part) => part.trim());
                setSelectValueOrAddOption(editProvince, addressParts[2] || '');
                updateMunicipalities(editProvince, editMunicipality, editBarangay);
                setSelectValueOrAddOption(editMunicipality, addressParts[1] || '');
                updateBarangays(editProvince, editMunicipality, editBarangay);
                setSelectValueOrAddOption(editBarangay, addressParts[0] || '');
            } else {
                if (province) {
                    setSelectValueOrAddOption(editProvince, province);
                } else {
                    editProvince.value = '';
                }
                updateMunicipalities(editProvince, editMunicipality, editBarangay);
                if (municipality) {
                    setSelectValueOrAddOption(editMunicipality, municipality);
                } else {
                    editMunicipality.value = '';
                }
                updateBarangays(editProvince, editMunicipality, editBarangay);
                if (barangay) {
                    setSelectValueOrAddOption(editBarangay, barangay);
                }
            }
        }

        const addressInput = formRoot.querySelector('input[name="address"]');
        if (addressInput) {
            addressInput.value = address;
        }

        const programSelect = formRoot.querySelector('select[name="program"]');
        if (programSelect) {
            programSelect.value = program;
            if (program && programSelect.value !== program) {
                setSelectValueOrAddOption(programSelect, program);
            }
        }

        const sourceField = formRoot.querySelector('[name="source"]');
        if (sourceField) sourceField.value = source;

        const lineSelect = formRoot.querySelector('select[name="line"]');
        if (lineSelect) {
            lineSelect.value = line;
            if (line && lineSelect.value !== line) {
                setSelectValueOrAddOption(lineSelect, line);
            }
        }

        const causeInput = formRoot.querySelector('input[name="causeOfDamage"]');
        if (causeInput) causeInput.value = causeOfDamage;

        const modeOfPaymentSelect = formRoot.querySelector('select[name="modeOfPayment"]');
        if (modeOfPaymentSelect) {
            modeOfPaymentSelect.value = modeOfPayment;
        }

        const remarksInput = formRoot.querySelector('input[name="remarks"]');
        if (remarksInput) remarksInput.value = remarks;

        const accountsInput = formRoot.querySelector('input[name="accounts"]');
        if (accountsInput) accountsInput.value = accounts;

        const facebookPageUrlInput = formRoot.querySelector('input[name="facebook_page_url"]');
        if (facebookPageUrlInput) facebookPageUrlInput.value = fbPageUrl;

        const dateOccurrenceField = formRoot.querySelector('[name="date_occurrence"]');
        if (dateOccurrenceField) dateOccurrenceField.value = dateOccurrence;

        const dateReceivedField = formRoot.querySelector('[name="date_received"]');
        if (dateReceivedField) dateReceivedField.value = dateReceived;

        const transmittalInput = formRoot.querySelector('input[name="transmittal_number"]');
        if (transmittalInput) transmittalInput.value = transmittalNumber;

        const adminTransmittalInput = formRoot.querySelector('input[name="admin_transmittal_number"]');
        if (adminTransmittalInput) adminTransmittalInput.value = adminTransmittalNumber;

        const clearAdminTransmittalCheckbox = formRoot.querySelector('input[name="clear_admin_transmittal_number"]');
        if (clearAdminTransmittalCheckbox) {
            clearAdminTransmittalCheckbox.checked = false;
        }

        if (editRecordAddress && editProvince && editMunicipality && editBarangay) {
            setHiddenAddress(editProvince, editMunicipality, editBarangay, editRecordAddress);
        }

        const editDialog = document.getElementById('recordEditDialog') || document.querySelector('.editRecordDialog');
        if (editDialog) {
            editDialog.showModal();
        }
    }

    document.addEventListener('click', function (e) {
        const t = e.target;
        if (!t || !t.closest) {
            return;
        }
        const button = t.closest('.editButton');
        if (!button) {
            return;
        }
        e.preventDefault();
        openRecordEditDialog(button);
    });

    const editProvinceInput = document.getElementById('editProvince');
    const editMunicipalityInput = document.getElementById('editMunicipality');
    const editBarangayInput = document.getElementById('editBarangay');
    const editRecordForm = document.getElementById('recordEditForm');
    const editRecordAddressInput = document.getElementById('editRecordAddress');

    if (editProvinceInput && editMunicipalityInput && editBarangayInput) {
        editProvinceInput.addEventListener('change', function () {
            updateMunicipalities(editProvinceInput, editMunicipalityInput, editBarangayInput);
        });

        editMunicipalityInput.addEventListener('change', function () {
            updateBarangays(editProvinceInput, editMunicipalityInput, editBarangayInput);
        });
    }

    if (editRecordForm) {
        editRecordForm.addEventListener('submit', function () {
            setHiddenAddress(editProvinceInput, editMunicipalityInput, editBarangayInput, editRecordAddressInput);
            capitalizeInputs(editRecordForm);
        });
    }

    // Global function to reset all form submission states
    function resetAllFormSubmissionStates() {
        const addRecordForms = document.querySelectorAll('form[action*="records"]');
        addRecordForms.forEach(form => {
            form.isSubmitting = false;
            const submitButtons = form.querySelectorAll('button[type="submit"]');
            submitButtons.forEach(btn => {
                btn.disabled = false;
                btn.classList.remove('disabled', 'opacity-50');
            });
        });
        console.log('All form submission states reset');
    }

    // Function to initialize form submission handlers
    function initializeFormHandlers() {
        const addRecordForms = document.querySelectorAll('form[action*="records"]');

        // Filter out the edit record form from the forms to handle
        // The edit record form has its own submit handler defined above (line 1456-1461)
        const formsToHandle = Array.from(addRecordForms).filter(form => form.id !== 'recordEditForm');
        
        console.log('Found forms to handle:', formsToHandle.length);
        formsToHandle.forEach((form, index) => {
            // Skip if already initialized
            if (form.formHandlerInitialized) {
                console.log(`Form ${index + 1} already initialized, skipping`);
                return;
            }
            
            console.log(`Form ${index + 1}:`, form.action, form.id);
            // Add a flag to track submission state
            form.isSubmitting = false;
            form.formHandlerInitialized = true;
            
            form.addEventListener('submit', function (e) {
                console.log('Form submit event triggered');
                console.log('Form isSubmitting:', form.isSubmitting);
                
                // Prevent multiple submissions
                if (form.isSubmitting) {
                    e.preventDefault();
                    console.log('Form already submitting, preventing submission');
                    return false;
                }
                
                // Check if this is an edit record form (multiple detection methods)
                const isEditForm = (form.method && form.method.toUpperCase() === 'PUT') ||
                                  (form.id && form.id === 'recordEditForm') ||
                                  (form.action && form.action.includes('/records/') && form.action.match(/\/records\/\d+/));
                
                // Check if this is the filter form (should not show confirmation modal)
                const isFilterForm = (form.id && form.id === 'filterForm') ||
                                   (form.action && form.action.includes('/all-records'));
                
                if (isEditForm || isFilterForm) {
                    // For edit forms and filter forms, just capitalize inputs and submit directly
                    if (isFilterForm) {
                        console.log('Filter form detected, submitting directly without confirmation');
                    } else {
                        console.log('Edit form detected, submitting directly without confirmation');
                    }
                    console.log('Form action:', form.action);
                    console.log('Form method:', form.method);
                    console.log('Form ID:', form.id);
                    console.log('Form data before submission:');
                    const formData = new FormData(form);
                    for (let [key, value] of formData.entries()) {
                        console.log(`${key}: ${value}`);
                    }
                    capitalizeInputs(form);
                    console.log('Capitalize inputs completed, allowing default submission');
                    
                    // Remove the event listener to prevent any interference
                    form.removeEventListener('submit', arguments.callee);
                    return; // Allow default form submission
                }
                
                console.log('Preventing default form submission');
                e.preventDefault();
                e.stopPropagation();
                
                form.isSubmitting = true;
                console.log('Form submission started, isSubmitting set to true');
                
                // Capitalize inputs first
                capitalizeInputs(form);
                
                // Show confirmation modal
                const confirmModal = document.getElementById('confirmModal');
                if (confirmModal) {
                    confirmModal.showModal();
                    
                    // Handle modal buttons
                    const continueBtn = document.getElementById('confirmModalContinue');
                    const cancelBtn = document.getElementById('confirmModalCancel');
                    
                    // Remove existing event listeners
                    const newContinueBtn = continueBtn.cloneNode(true);
                    const newCancelBtn = cancelBtn.cloneNode(true);
                    continueBtn.parentNode.replaceChild(newContinueBtn, continueBtn);
                    cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
                    
                    // Add event listeners
                    newContinueBtn.addEventListener('click', function() {
                        confirmModal.close();
                        console.log('Continue clicked, proceeding with submission');
                        // Submit directly without duplicate check
                        submitFormViaAjax(form);
                    });
                    
                    newCancelBtn.addEventListener('click', function() {
                        confirmModal.close();
                        console.log('Cancel clicked, resetting form state');
                        // Reset form submission state to allow re-submission
                        setTimeout(() => {
                            form.isSubmitting = false;
                            console.log('Form isSubmitting reset to false');
                            // Remove any disabled attributes from submit buttons
                            const submitButtons = form.querySelectorAll('button[type="submit"]');
                            submitButtons.forEach(btn => {
                                btn.disabled = false;
                                btn.classList.remove('disabled', 'opacity-50');
                            });
                        }, 100);
                    });
                    
                    // Also reset form state when modal is closed by other means (ESC key, backdrop click)
                    confirmModal.addEventListener('close', function() {
                        if (form.isSubmitting) {
                            console.log('Modal closed, resetting form state');
                            form.isSubmitting = false;
                            const submitButtons = form.querySelectorAll('button[type="submit"]');
                            submitButtons.forEach(btn => {
                                btn.disabled = false;
                                btn.classList.remove('disabled', 'opacity-50');
                            });
                        }
                    }, { once: true });
                    
                    // Additional fix for email handler - also reset when the add record dialog is closed
                    const addRecordDialog = form.closest('.addRecordDialog');
                    if (addRecordDialog) {
                        addRecordDialog.addEventListener('close', function() {
                            console.log('Add record dialog closed, resetting form state');
                            form.isSubmitting = false;
                            const submitButtons = form.querySelectorAll('button[type="submit"]');
                            submitButtons.forEach(btn => {
                                btn.disabled = false;
                                btn.classList.remove('disabled', 'opacity-50');
                            });
                        }, { once: true });
                    }
                }
            });
        });
    }

    // Initialize form handlers on page load
    initializeFormHandlers();

    // Also initialize when dialogs are opened (for dynamic content)
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1) { // Element node
                        // Check if this is a dialog that contains forms
                        if (node.tagName === 'DIALOG' || node.querySelector('dialog')) {
                            console.log('Dialog detected, re-initializing form handlers');
                            setTimeout(initializeFormHandlers, 100);
                        }
                    }
                });
            }
        });
    });

    // Start observing the document body for changes
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });

    // Function to submit form via AJAX and show notification
    function submitFormViaAjax(form) {
        console.log('submitFormViaAjax called');
        const formData = new FormData(form);
        const submitButton = form.querySelector('button[type="submit"]');
        const addRecordDialog = form.closest('.addRecordDialog');
        
        console.log('Add record dialog found:', !!addRecordDialog);
        console.log('Dialog open state:', addRecordDialog ? addRecordDialog.open : 'N/A');
        
        // Disable submit button during submission
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Submitting...';
        }

        // Submit form via AJAX
        fetch(form.action, {
            method: form.method || 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Submit response status:', response.status);
            console.log('Submit response headers:', response.headers.get('content-type'));
            
            // Check if response is OK
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Response is not JSON');
            }
            
            return response.json();
        })
        .then(data => {
            console.log('Submit response data:', data);
            console.log('Dialog open state after response:', addRecordDialog ? addRecordDialog.open : 'N/A');
            
            if (data.success) {
                // Show success modal
                const successModal = document.getElementById('successModal');
                console.log('Success modal element found:', !!successModal);
                if (successModal) {
                    console.log('Showing success modal');
                    successModal.showModal();
                    
                    // Add event listener to OK button
                    const successModalOk = document.getElementById('successModalOk');
                    if (successModalOk) {
                        successModalOk.addEventListener('click', function() {
                            successModal.close();
                            
                            // Save location values before resetting form
                            const provinceSelect = form.querySelector('#province');
                            const municipalitySelect = form.querySelector('#municipality');
                            const barangaySelect = form.querySelector('#barangay');
                            
                            const savedProvince = provinceSelect ? provinceSelect.value : '';
                            const savedMunicipality = municipalitySelect ? municipalitySelect.value : '';
                            const savedBarangay = barangaySelect ? barangaySelect.value : '';
                            
                            console.log('Saved location values before reset:', savedProvince, savedMunicipality, savedBarangay);
                            
                            // Reset form fields for continuous encoding
                            form.reset();
                            
                            // Restore location values after reset
                            if (provinceSelect && savedProvince) {
                                provinceSelect.value = savedProvince;
                                // Enable municipality dropdown
                                if (municipalitySelect) {
                                    municipalitySelect.disabled = false;
                                    const event = new Event('change');
                                    provinceSelect.dispatchEvent(event);
                                    
                                    setTimeout(() => {
                                        if (municipalitySelect && savedMunicipality) {
                                            municipalitySelect.value = savedMunicipality;
                                            // Enable barangay dropdown
                                            if (barangaySelect) {
                                                barangaySelect.disabled = false;
                                                const municipalityEvent = new Event('change');
                                                municipalitySelect.dispatchEvent(municipalityEvent);
                                                
                                                setTimeout(() => {
                                                    if (barangaySelect && savedBarangay) {
                                                        barangaySelect.value = savedBarangay;
                                                    }
                                                }, 100);
                                            }
                                        }
                                    }, 100);
                                }
                            }
                            
                            // Focus on first input field
                            const firstInput = form.querySelector('input:not([type="hidden"]):not([type="checkbox"])');
                            if (firstInput) {
                                firstInput.focus();
                            }
                            
                            // Update records table if it exists
                            console.log('About to update records table...');
                            updateRecordsTable();
                            console.log('Records table updated');
                        }, { once: true });
                    }
                }
                
                console.log('Dialog open state after success:', addRecordDialog ? addRecordDialog.open : 'N/A');
                
            } else {
                // Show error notification
                showNotification(data.message || 'Error adding record. Please try again.', 'error');
            }
        })
        .catch(error => {
            console.error('Error submitting form:', error);
            console.error('Error details:', error.message);
            showNotification('Error adding record. Please try again.', 'error');
            
            // Re-open the dialog if it was closed
            if (addRecordDialog && !addRecordDialog.open) {
                console.log('Re-opening dialog after error');
                addRecordDialog.showModal();
            }
        })
        .finally(() => {
            // Re-enable submit button
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = 'Add Record';
            }
            
            // Reset form submission state
            form.isSubmitting = false;
            console.log('Form submission reset, dialog open state:', addRecordDialog ? addRecordDialog.open : 'N/A');
        });
    }

    // Function to show notification
    function showNotification(message, type = 'success') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateX(100%);
            transition: transform 0.3s ease;
            max-width: 400px;
        `;
        
        // Set background and text color based on type
        if (type === 'success') {
            notification.style.backgroundColor = '#10b981';
            notification.style.color = 'white';
        } else if (type === 'error') {
            notification.style.backgroundColor = '#ef4444';
            notification.style.color = 'white';
        }
        
        notification.textContent = message;
        
        // Add to page
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // Function to update records table (if it exists)
    function updateRecordsTable() {
        console.log('updateRecordsTable called');
        // Try to refresh the records table without page reload
        const tableContainer = document.querySelector('.table-wrapper');
        console.log('Table container found:', !!tableContainer);
        
        if (tableContainer) {
            // Get current URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const currentUrl = window.location.pathname + '?' + urlParams.toString();
            console.log('Fetching table from:', currentUrl);
            
            // Fetch updated table content
            fetch(currentUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('Table update response status:', response.status);
                return response.text();
            })
            .then(html => {
                console.log('Table update HTML received, length:', html.length);
                // Create a temporary element to parse the HTML
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                
                // Find the new table content
                const newTableContainer = tempDiv.querySelector('.table-wrapper');
                if (newTableContainer) {
                    console.log('New table container found, updating...');
                    tableContainer.innerHTML = newTableContainer.innerHTML;
                    console.log('Table updated successfully');
                } else {
                    console.log('New table container not found in response');
                }
            })
            .catch(error => {
                console.error('Error updating table:', error);
                // If table update fails, it's okay - the record was still added
            });
        } else {
            console.log('No table container found, skipping table update');
        }
    }

    // Table Search Button Functionality
    const tableSearchBtn = document.getElementById('table-search-btn');
    if (tableSearchBtn) {
        tableSearchBtn.addEventListener('click', function (e) {
            e.preventDefault();

            // Collect all filter values from table header
            const filterRow = document.querySelector('thead tr.filter-row');
            if (!filterRow) return;

            const params = new URLSearchParams();
            const inputs = filterRow.querySelectorAll('input, select');

            inputs.forEach(input => {
                const name = input.getAttribute('name');
                const value = input.value;
                if (name && value) {
                    params.append(name, value);
                }
            });

            // Build URL and search
            const searchUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
            window.location.href = searchUrl;
        });
    }

    // Delete Record Dialog

    document.querySelectorAll('.deleteButton').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const farmerName = this.getAttribute('data-farmer-name');
            const deleteForm = document.querySelector('.deleteRecordForm');
            const message = document.querySelector('.deleteRecordMessage');
            const deleteDialog = document.querySelector('.deleteRecordDialog');

            if (deleteForm) {
                deleteForm.action = `/records/${id}`;
            }

            if (message) {
                message.textContent = `Record for ${farmerName} will be deleted.`;
            }

            if (deleteDialog) {
                deleteDialog.showModal();
            }
        });
    });

    // Cancel Delete Button
    const cancelDeleteButton = document.querySelector('.cancelDeleteRecord');
    const deleteRecordDialog = document.querySelector('.deleteRecordDialog');

    if (cancelDeleteButton && deleteRecordDialog) {
        cancelDeleteButton.addEventListener('click', function () {
            deleteRecordDialog.close();
        });
    }

    const closeEditRecordDialog = document.querySelector('.closeEditRecordDialog');
    const editRecordDialog = document.getElementById('recordEditDialog') || document.querySelector('.editRecordDialog');

    if (closeEditRecordDialog && editRecordDialog) {
        closeEditRecordDialog.addEventListener('click', function () {
            editRecordDialog.close();
        });
    }

    // Select all checkbox
    const selectAllCheckbox = document.getElementById('select-all');
    const recordCheckboxes = document.querySelectorAll('.record-checkbox');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function () {
            recordCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

    // Auto-caps functionality for text inputs
    function capitalizeInputs(form) {
        const autoCapsInputs = form.querySelectorAll('.auto-caps');
        autoCapsInputs.forEach(input => {
            if (input.value) {
                // Capitalize each word in the input
                input.value = input.value.replace(/\b\w/g, char => char.toUpperCase());
            }
        });
    }

    // Bulk Delete Dialog
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    const bulkDeleteDialog = document.querySelector('.bulkDeleteDialog');
    const bulkDeleteList = document.querySelector('.bulk-delete-list');
    const confirmBulkDelete = document.getElementById('confirm-bulk-delete');
    const cancelBulkDelete = document.querySelector('.cancelBulkDelete');
    const bulkForm = document.getElementById('bulk-form');

    if (bulkDeleteBtn && bulkDeleteDialog) {
        bulkDeleteBtn.addEventListener('click', function () {
            const selectedCheckboxes = document.querySelectorAll('.record-checkbox:checked');
            if (selectedCheckboxes.length === 0) {
                showModalMessage('Please select at least one record to delete.', 'warning');
                return;
            }

            // Clear previous list
            bulkDeleteList.innerHTML = '';

            // Add selected farmers to the list
            selectedCheckboxes.forEach(checkbox => {
                const farmerName = checkbox.dataset.farmerName || checkbox.closest('tr').cells[3].textContent;
                const li = document.createElement('li');
                li.textContent = farmerName;
                bulkDeleteList.appendChild(li);
            });

            bulkDeleteDialog.showModal();
        });
    }

    if (confirmBulkDelete && bulkForm) {
        confirmBulkDelete.addEventListener('click', function () {
            bulkDeleteDialog.close();
            bulkForm.submit();
        });
    }

    if (cancelBulkDelete && bulkDeleteDialog) {
        cancelBulkDelete.addEventListener('click', function () {
            bulkDeleteDialog.close();
        });
    }

    // Add Admin Dialog
    const addAdminButton = document.querySelector('.addAdminButton');
    const addAdminDialog = document.querySelector('.addAdminDialog');
    const closeAddAdminDialog = document.querySelector('.closeAddAdminDialog');

    if (addAdminButton && addAdminDialog) {
        addAdminButton.addEventListener('click', function () {
            addAdminDialog.showModal();
        });
    }

    if (closeAddAdminDialog && addAdminDialog) {
        closeAddAdminDialog.addEventListener('click', function () {
            addAdminDialog.close();
        });
    }

    // Edit Admin Dialog
    const editAdminButtons = document.querySelectorAll('.editAdminButton');
    const editAdminDialog = document.querySelector('.editAdminDialog');
    const closeEditAdminDialog = document.querySelector('.closeEditAdminDialog');
    const editAdminForm = document.querySelector('.editAdminForm');

    editAdminButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const username = this.getAttribute('data-username');

            if (editAdminForm) {
                editAdminForm.action = `/admin/users/${id}`;
            }

            const usernameInput = document.querySelector('#adminUsername');
            if (usernameInput) usernameInput.value = username;

            if (editAdminDialog) {
                editAdminDialog.showModal();
            }
        });
    });

    if (closeEditAdminDialog && editAdminDialog) {
        closeEditAdminDialog.addEventListener('click', function () {
            editAdminDialog.close();
        });
    }
});
