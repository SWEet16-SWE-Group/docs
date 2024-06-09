import React, { useEffect, useState } from "react";
import { Link, useParams } from 'react-router-dom';
import axiosClient from '../axios-client.js';
import { useStateContext } from '../contexts/ContextProvider.jsx';

function DivisioneConto({setEquo, setProp, role}){
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
            <td width="50%"><button className="btn btn-block" onClick={setEquo}>Equo</button></td>
            <td><button className="btn btn-block" onClick={setProp}>Proporzionale</button></td>
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

function Pagamento({role, tipo}){
  async function a(){}
  return (
    <h2>Pagamenti</h2>
  )
}

export default function DivisioneContoPagamento() {

    const {user, profile, token, role, notification, notificationStatus, setUser, setToken, setRole} = useStateContext()
    const {id} = useParams();
    const [prenotazione, setPrenotazione] = useState(null);

    async function fetchPrenotazione() {
      const {data:data} = await axiosClient.get(`/prenotazione_conto/${id}`);
      setPrenotazione(data);
    };

    useEffect(() => { fetchPrenotazione(); }, []);

    async function setDivisione(modo){
      const {data: data} = await axiosClient.post(`/set_divisioneconto/${id}`,({divisione_conto: modo}))
      setPrenotazione(data);
    }

    const divisioneconto = prenotazione && prenotazione.divisione_conto == null;
    const tipodivisione =  prenotazione && prenotazione.divisione_conto;

    return (
        <div className="container mt-5">
          <h1>{prenotazione && prenotazione.nome}</h1>
          <h2>Dettagli</h2>
          <div>Data: {prenotazione && prenotazione.orario}</div>
          {
            divisioneconto
            ? <DivisioneConto role={role} setEquo={() => setDivisione('Equo')} setProp={() => setDivisione('Proporzionale')}/>
            : <div>Divisione conto: {tipodivisione}</div>
          }
          {!divisioneconto && <Pagamento role={role} tipo={tipodivisione} />}
        </div>
    );
}
