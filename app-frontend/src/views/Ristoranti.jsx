import {useEffect, useRef, useState} from "react";
import {Link, useNavigate} from "react-router-dom";
import axiosClient from "../axios-client.js";
import {createRef} from "react";
import {useStateContext} from "../contexts/ContextProvider.jsx";

function ristoranti(set) {
  axiosClient.get('/ristoranti').then(
    data => { set(data.data) }
  )
}

function url(id){
  return `/ristorante/${id}`;
}

function ristorante(a){
  return (
    <a href={url(a.id)} key={a.id}> {a.nome} @ {a.indirizzo} # {a.telefono} | {a.orario} </a>
  );
}

export default function Ristoranti() {
    const [r,sr] = useState(null);
    useEffect(() => ristoranti(sr) ,[]);
    return (
        <div>
            {r ? r.map(ristorante) : <div>Nessun ristorante ancora registrato</div>}
        </div>
    )
}
