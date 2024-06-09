import React, { useEffect, useState } from "react";
import { Link, useNavigate, useParams } from 'react-router-dom';
import axiosClient from '../axios-client.js';
import { useStateContext } from '../contexts/ContextProvider.jsx';

export default function LinkInvito() {

    const {profile, notification, notificationStatus, setNotification, setNotificationStatus} = useStateContext()
    const {prenotazione} = useParams();
    const [errorMessage, setErrorMessage] = useState(null);
    const navigate = useNavigate();

    function accetta() {
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

    function ignora() {
      navigate('/dashboardcliente/');
    }

    useEffect(() => {
    }, []);
    
    return (
      <table>
        <thead>
          <tr>
            <th colSpan="2">Sei stato invitato a partecipare a quest'uscita</th>
          </tr>
          <tr>
            <th colSpan="2">
              <div> &lt;&lt; Dettagli prenotazione &gt;&gt; </div>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><button className="btn btn-block" onClick={accetta}>Accetta</button></td>
            <td><button className="btn btn-block" onClick={ignora}>Ignora</button></td>
          </tr>
        </tbody>
      </table>
    );
}
