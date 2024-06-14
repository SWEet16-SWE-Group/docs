import {useEffect, useRef, useState} from "react";
import {Link, useNavigate} from "react-router-dom";
import axiosClient from "../axios-client.js";
import {createRef} from "react";
import {useStateContext} from "../contexts/ContextProvider.jsx";
import RestaurantCard from "../components/RestaurantCard.jsx";

function riga(a){
  const b = ({
    'PRENOTAZIONE CREATA':    a => ({
      desc:<p>{a.cliente.nome} ha creato una <Link to="">prenotazione</Link>.</p>
    }),
    'PRENOTAZIONE STATO':     a => ({
      desc:<p>{a.ristoratore.nome} ha reso tua <Link to="">prenotazione</Link>: {a.prenotazione.stato}.</p>
    }),
    'PRENOTAZIONE CONTO':     a => ({
      desc:<p>{a.cliente.nome} ha scelto una divisione del conto per la <Link to="">prenotazione</Link>.</p>
    }),
    'PRENOTAZIONE CANCELLATA':a => ({
      desc:<p>{a.cliente.nome} ha cancellato la sua prenotazione.</p>
    }),
    'INVITO ACCETTATO':       a => ({
      desc:<p>{a.cliente.nome} ha accettato l'invito alla <Link to="">prenotazione</Link>.</p>
    }),
    'INVITO PAGATO':          a => ({
      desc:<p>{a.cliente.nome} ha pagato la sua <Link to="">quota</Link>.</p>
    }),
    'ORDINAZIONE CREATA':     a => ({
      desc:<p>{a.cliente.nome} ha ordinato: <Link to="">{a.pietanza.nome}</Link>.</p>
    }),
    'ORDINAZIONE CANCELLATA': a => ({
      desc:<p>{a.cliente.nome} ha cancellato la sua ordinazione.</p>
    }),
    'ORDINAZIONE PAGATA':     a => ({
      desc:<p>{a.cliente.nome} ha pagato: <Link to="">{a.pietanza.nome}</Link>.</p>
    }),
  })[a.significato](a);
  const c = ({time: a.created_at, desc: b.desc});
  return (<tr key={c.time}><td>{c.time}</td><td>{c.desc}</td></tr>);
}

export default function Notifiche() {
    const {role, profile} = useStateContext();
    const [notifiche, setNotifiche] = useState(null);

    async function fetch(){
      const {data: data} = await axiosClient.get(`/notifiche_info/${role}/${profile}`);
      setNotifiche(data);
    }

    //useEffect(() => { fetch(); }, []);

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
            </tbody>
          </table>
        </div>
    )
}
