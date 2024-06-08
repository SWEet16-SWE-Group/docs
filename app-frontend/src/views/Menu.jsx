import {useParams} from "react-router-dom";
import {useEffect, useRef, useState} from "react";
import {Link, useNavigate} from "react-router-dom";
import axiosClient from "../axios-client.js";
import {createRef} from "react";
import {useStateContext} from "../contexts/ContextProvider.jsx";

function fetch(id,set) {
  axiosClient.get(`/menu/${id}`).then(
    data => { set(data.data) }
  )
}

function pietanza(a, prenotazione){
  const url = (prenotazione,pietanza) => `/formordinazione/${prenotazione}/${pietanza}`;
  return (
    <div key={a.id}>
      <h1> {a.nome} </h1>
      <p> {a.ingredienti} </p>
      {prenotazione && <a href={url(prenotazione, a.id)} >aaaaa</a>}
    </div>
  );

}

export default function Menu() {
    const {prenotazione, ristorante} = useParams();
    console.log(ristorante, prenotazione);
    const [r,sr] = useState(null);
    useEffect(() => fetch(ristorante,sr) ,[]);
    return (<div>{r && r.map(a => pietanza(a, prenotazione))}</div>)
}
