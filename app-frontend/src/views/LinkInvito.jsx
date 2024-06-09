import React, { useEffect, useState } from "react";
import { Link, useNavigate, useParams } from 'react-router-dom';
import axiosClient from '../axios-client.js';
import { useStateContext } from '../contexts/ContextProvider.jsx';

export default function LinkInvito() {

    const {profile, notification, notificationStatus, setNotification, setNotificationStatus} = useStateContext()
    const {prenotazione} = useParams();
    const [errorMessage, setErrorMessage] = useState(null);
    const navigate = useNavigate();

    const ping = () => {
      axiosClient.post('/crea-invito/',({prenotazione:prenotazione, cliente:profile})).then(
        data => { 
        console.log(data);
          navigate(`/dettagliprenotazionecliente/${prenotazione}`);
        }
      ).catch(
        data => {
            setNotificationStatus('error');
            setNotification('Errore durante l\'invito alla prenotazione.');
            setErrorMessage('Errore durante l\'invito alla prenotazione.');
        }
      );
    };

    useEffect(ping, []);
    
}
