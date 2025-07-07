import { useEffect } from "react";
import { useLocation } from "react-router-dom";

const titleMap = {
    '/' : 'Login | casier',
    '/home' : 'Accueil | casier',
    '/casier' : 'Gestion casier | casier',
    '/identification' : 'Identification | casier',
    '/infocasier' : 'Info casier | casier',
    '/infraction' : 'Infraction | casier',
    '/dossier_patiente' : 'Dossier | casier',
    '/liste-rdv' : 'Rendez-vous | casier',

}

const TitleMgm = () => {
    const location = useLocation();

    useEffect(() => {
        document.title = titleMap[location.pathname] || 'casier';
        localStorage.setItem('title', titleMap[location.pathname]);
    }, [location.pathname]);

    return null;
}

export default TitleMgm;