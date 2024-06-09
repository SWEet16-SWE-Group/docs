import React, { useEffect, useState } from "react";
import { Link, useParams } from 'react-router-dom';
import axiosClient from '../axios-client.js';
import { useStateContext } from '../contexts/ContextProvider.jsx';

async function setDivisione(modo, id){
  const data = await axiosClient.post(`/set_divisioneconto/${id}`,({divisione_conto: modo}))
  console.log(data);
}

function DivisioneConto(){
  const {user, profile, token, role, notification, notificationStatus, setUser, setToken, setRole} = useStateContext()
  const {id} = useParams();
  const equo = () => setDivisione('Equo', id);
  const proporzionale = () => setDivisione('Proporzionale', id);
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
            <td width="50%"><button className="btn btn-block" onClick={equo}>Equo</button></td>
            <td><button className="btn btn-block" onClick={proporzionale}>Proporzionale</button></td>
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

function Pagamento({tipo}){
  return <div>Pagamento di tipo: {tipo}</div>;
}

export default function DivisioneContoPagamento() {

    const {user, profile, token, role, notification, notificationStatus, setUser, setToken, setRole} = useStateContext()
    const {id} = useParams();
    const [prenotazione, setPrenotazione] = useState(null);

    const fetchPrenotazione = () => {
      axiosClient.get(`/prenotazione_conto/${id}`).then(
        data => { 
          setPrenotazione(data.data);
          console.log(data.data);
        }
      );
    };

    useEffect(fetchPrenotazione, []);

    console.log(prenotazione);

    const divisioneconto = prenotazione && prenotazione.divisione_conto == null;
    const tipodivisione =  prenotazione && prenotazione.divisione_conto;

    return (
        <div className="container mt-5">
          <h1>{prenotazione.nome}</h1>
          <h2>Dettagli</h2>
          <div>Data: {prenotazione.orario}</div>
          {divisioneconto ? <DivisioneConto /> : <div>Divisione conto: {tipodivisione}</div>}
          {!divisioneconto && <Pagamento tipo={tipodivisione} />}
        </div>
    );
}
