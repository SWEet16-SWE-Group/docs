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

function url(id){
  return `/menu/${id}`;
}

function Bottoneprenota(a){
  const {role} = useStateContext();
  if (role === 'CLIENTE') {
    return (<div>PRENOTA ORA STRONZO</div>);
  }else{
    return (<div></div>);
  }
}

function ristorante(a){
  return (
    <div key={a.id}>
      <h1> {a.nome} </h1>
      <p> {a.indirizzo} </p>
      <p> {a.telefono} </p>
      <p> {a.orario} </p>
      <a href={url(a.id)}> Menù </a>
      {Bottoneprenota(a)}
    </div>
  );
}

export default function Ristorante() {
    const {id} = useParams();
    const [r,sr] = useState(null);
    useEffect(() => fetch(id,sr) ,[]);
    return (<div>{r && ristorante(r)}</div>)
}
