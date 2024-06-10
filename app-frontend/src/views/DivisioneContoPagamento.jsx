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

export default function DivisioneContoPagamento() {

    const {user, profile, token, role, notification, notificationStatus, setUser, setToken, setRole} = useStateContext()
    const {id} = useParams();
    const [prenotazione, setPrenotazione] = useState(null);
    const [pagamenti, setPagamenti] = useState(null);

    async function fetchPagamenti(tipo){
      const url = ({
        'Equo':`/pagamenti_inviti/${id}`,
        'Proporzionale':`/pagamenti_ordinazioni/${id}`,
      })[tipo];
      const {data: pagamenti} = await axiosClient.get(url);
      setPagamenti(pagamenti);
    }

    async function fetchPrenotazione() {
      const {data:data} = await axiosClient.get(`/prenotazione_conto/${id}`);
      setPrenotazione(data);
      if (data.divisione_conto) {
        fetchPagamenti(data.divisione_conto);
      }
    };

    useEffect(() => { fetchPrenotazione(); }, []);

    async function setDivisione(modo){
      const {data: data} = await axiosClient.post(`/set_divisioneconto/${id}`,({divisione_conto: modo}))
      setPrenotazione(data);
    };

    function setPagato(id,tipo){
      return async function () {
          const url = ({
            'Equo':`/paga_invito/${id}`,
            'Proporzionale':`/paga_ordinazione/${id}`,
          })[tipo];
          const {data: data} = await axiosClient.post(url, ({}));
          fetchPagamenti(tipo);
      };
    };

    function BottonePagamento({pagato, risto, io, click}) {
      return (
          pagato
          ? "Pagato"
          : (
              risto
              ? <button className="btn btn-block" onClick={click}>Segna come pagato</button>
              : (
                  io
                  ? <button className="btn btn-block" onClick={click}>Paga</button>
                  : "Non pagato"
                )
            )
          );
    }

    function renderPagamentoEquo(p){
      return <tr key={p.id}>
        <td>{p.cliente}</td>
        <td>
          <BottonePagamento
            pagato={p.pagamento_c == 'PAGATO'}
            risto={role == 'RISTORATORE'}
            io={profile == p.cid}
            click={setPagato(p.id,'Equo')}
          />
        </td>
      </tr> ;
    };

    function renderPagamentoProporzionale(p){
      return <tr key={p.oid}>
        <td>{p.cliente}</td>
        <td>{p.pietanza}</td>
        <td>{p.aggiunte}</td>
        <td>{p.rimozioni}</td>
        <td>
          <BottonePagamento
            pagato={p.pagamento_o == 'PAGATO'}
            risto={role == 'RISTORATORE'}
            io={profile == p.cid}
            click={setPagato(p.oid,'Proporzionale')}
          />
        </td>
      </tr>;
    };

    const divisioneconto = prenotazione && (prenotazione.divisione_conto == null);
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
          {
            !divisioneconto &&
            <div>
              <h2>Pagamenti</h2>
              <table>
                <tbody>
                  {pagamenti && pagamenti.map(({'Equo': renderPagamentoEquo, 'Proporzionale':renderPagamentoProporzionale})[tipodivisione])}
                </tbody>
              </table>
            </div>
          }
          <br />
          <div>
              {role === 'RISTORATORE' &&
                  <Link to={`/dashboardristoratore`} type="button" className="btn btn-secondary ms-2" >Annulla</Link>
              }

              {role === 'CLIENTE' &&
                  <Link to={`/dettagliprenotazionecliente/${id}`} type="button" className="btn btn-secondary ms-2" >Annulla</Link>
              }
          </div>
        </div>
    );
}
