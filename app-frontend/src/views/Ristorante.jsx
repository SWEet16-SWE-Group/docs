import {useParams} from "react-router-dom";
import {useEffect, useRef, useState} from "react";
import {Link, useNavigate} from "react-router-dom";
import axiosClient from "../axios-client.js";
import {createRef} from "react";
import {useStateContext} from "../contexts/ContextProvider.jsx";

function fetch(id,set) {
  axiosClient.get(`/ristorante/${id}`).then(
    data => { set(data.data) }
  )
}

function Bottoneprenota(a){
  const url = (id) => `/formprenotazione/${id}`;
  const {role} = useStateContext();
  if (role === 'CLIENTE') {
    return (<Link to={url(a.id)}>Prenota</Link>);
  }else{
    return (<div></div>);
  }
}

function ristorante(a){
  const url = (id) => `/menu/${id}`;
  return (
      <>
          <div key={a.id}>
          <h1> Nome: {a.nome} </h1>
          <p> Indirizzo: {a.indirizzo} </p>
          <p> Telefono: {a.telefono} </p>
          <p> Orario apertura: {a.orario} </p>
          <Link to={url(a.id)}> Menù </Link>
            &nbsp;&nbsp;
          {Bottoneprenota(a)}
        </div>
          <br />
        <div>
            <Link to={'/ristoranti'} className="btn btn-primary ms-2" >Annulla</Link>
        </div>
      </>
  );
}

export default function Ristorante() {
    const {id} = useParams();
    const [r,sr] = useState(null);
    useEffect(() => fetch(id,sr) ,[]);
    return (<div>{r && ristorante(r)}</div>)
}
