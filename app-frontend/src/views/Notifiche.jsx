import {useEffect, useRef, useState} from "react";
import {Link, useNavigate} from "react-router-dom";
import axiosClient from "../axios-client.js";
import {createRef} from "react";
import {useStateContext} from "../contexts/ContextProvider.jsx";
import RestaurantCard from "../components/RestaurantCard.jsx";

function riga(a, role){
  const b = ({
    //RISTORATORE
    'PRENOTAZIONE CREATA':    a => ({
      desc:<p>{a.c_nome} ha creato una <Link to={`/dettagliprenotazioneristoratore/${a.p_id}`}>prenotazione</Link>.</p>,
    }),
    'PRENOTAZIONE CONTO':     a => ({
      desc:<p>È stata scelto una divisione del conto per la <Link to={`/divisionecontopagamentoristoratore/${a.p_id}`}>prenotazione</Link>.</p>,
    }),
    'ORDINAZIONE CREATA':     a => ({
      desc:<p>{a.c_nome} ha ordinato: <Link to={`/dettagliprenotazioneristoratore/${a.p_id}`}>{a.pz_nome}</Link>.</p>,
    }),
    'ORDINAZIONE PAGATA':     a => ({
      desc:<p>{a.c_nome} ha pagato: <Link to={`/divisionecontopagamento${role}/${a.p_id}`}>{a.pz_nome}</Link>.</p>,
    }),
    'INVITO PAGATO':          a => ({
      desc:<p>{a.c_nome} ha pagato la sua <Link to={`/divisionecontopagamentoristoratore/${a.p_id}`}>quota</Link>.</p>,
    }),

    //CLIENTE
    'PRENOTAZIONE STATO':     a => ({
      desc:<p>{a.r_nome} ha reso tua <Link to={`/prenotazione_c/${a.p_id}`}>prenotazione</Link>: {a.p_stato}.</p>,
    }),
    'INVITO ACCETTATO':       a => ({
      desc:<p>{a.c_nome} ha accettato l'invito alla <Link to={`/prenotazione_c/${a.p_id}`}>prenotazione</Link>.</p>,
    }),
  })[a.significato](a);
  const c = ({time: a.created_at, desc: b.desc});
  return (<tr key={c.time}><td>{c.time}</td><td>{c.desc}</td></tr>);
}

export default function Notifiche() {
    const {role, profile} = useStateContext();
    const [notifiche, setNotifiche] = useState(null);

    async function fetch(){
      const {data: data} = await axiosClient.get(`/notifiche_info/${role.toLowerCase()}/${profile}`);
      setNotifiche(data);
    }

    useEffect(() => { fetch(); }, []);

    return (
        <div>
          <table>
            <thead>
              <tr>
                <th>Tempo</th>
                <th>Descrizione</th>
              </tr>
            </thead>
            <tbody>
              {notifiche && notifiche.map(a => riga(a, role))}
            </tbody>
          </table>
        </div>
    )
}
