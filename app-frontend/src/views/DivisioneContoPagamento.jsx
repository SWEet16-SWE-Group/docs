import React, { useEffect, useState } from "react";
import { Link, useParams } from 'react-router-dom';
import axiosClient from '../axios-client.js';
import { useStateContext } from '../contexts/ContextProvider.jsx';

function setDivisione(modo){
  console.log(modo)
}

function DivisioneConto(){
  const {user, profile, token, role, notification, notificationStatus, setUser, setToken, setRole} = useStateContext()
  return ({
    'CLIENTE':(
      <table>
        <thead>
          <tr>
            <th colSpan="2">Quale modo di divione del conto preferisci ?</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td width="50%"><button className="btn btn-block" onClick={() => setDivisione('EQUA')}>Equa</button></td>
            <td><button className="btn btn-block" onClick={() => setDivisione('PROPORZIONALE')}>Proporzionale</button></td>
          </tr>
          <tr>
            <td>Il conto viene diviso in modo uguale per tutti.</td>
            <td>Ognuno paga il proprio.</td>
          </tr>
        </tbody>
      </table>
    ),
    'RISTORATORE':(
      <div>Non è ancora stata selezionata nessuna divisione del conto per questa prenotazione</div>
    ),
  })[role];
}

function Prenotazione(p){
  const url_p = (id) => `/divisionecontopagamento/${id}`;
  const url_o = (r,p) => `/menu/${r}/${p}`;
  const a = p.prenotazione;
    console.log(a.id);
  return (<div key={a.id}>
    <h1>{a.nome}</h1>
    <h2>Dettagli</h2>
    <div>Link di invito: <Link>localhost:3001/invito/{a.id}</Link></div>
    <div>Stato: {a.stato}</div>
    <div>Orario: {a.orario}</div>
    <div><Link to={url_p(a.id)}>Esamina pagamento</Link></div>
    <h2>Ordinazioni</h2>
    <div><Link to={url_o(a.ristoratore,a.id)}>Ordina</Link></div>
  </div>);
}

export default function DivisioneContoPagamento() {

    const {user, profile, token, role, notification, notificationStatus, setUser, setToken, setRole} = useStateContext()
    const {id} = useParams();
    const [prenotazione, setPrenotazione] = useState(null);

    const fetchPrenotazioni = () => {
      axiosClient.get(`/prenotazione_c/${id}`).then(
        data => { 
          setPrenotazione(data.data);
          console.log(data.data);
        }
      );
    };

    //useEffect(fetchPrenotazioni, []);

    return (
        <div className="container mt-5">
          &lt;&lt; DETTAGLI PRENOTAZIONE &gt;&gt;
          <DivisioneConto />
        </div>
    );
}
