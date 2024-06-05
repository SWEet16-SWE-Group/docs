import {createBrowserRouter, Navigate} from "react-router-dom";
import SignUp from "./views/SignUp.jsx";
import Login from "./views/Login";
import NotFound from "./views/NotFound.jsx";

import Layout from "./components/Layout"

import ModificaInfoAccount from "./views/ModificaInfoAccount";
import SelezioneProfilo from "./views/SelezioneProfilo";
import CreazioneProfiloRistoratore from "./views/CreazioneProfiloRistoratore";
import ModificaProfiloCliente from "./views/ModificaProfiloCliente";
import ModificaProfiloRistoratore from "./views/ModificaProfiloRistoratore";
import CreazioneProfiloCliente from "./views/CreazioneProfiloCliente.jsx";
import RistoratoreDashboard from "./views/DashboardRistoratore.jsx";
import GestioneMenu from "./views/GestioneMenu.jsx";
import GestioneIngredienti from "./views/GestioneIngredienti.jsx";
import FormPietanza from "./views/FormPietanza.jsx";
import FormIngrediente from "./views/FormIngredienti.jsx";

import Ristoranti from "./views/Ristoranti";
import Ristorante from "./views/Ristorante";
import Menu from "./views/Menu";

import {useStateContext} from "./contexts/ContextProvider";

function Autenticato () {
  const {token} = useStateContext()
  if(!token){
    return <Navigate to={"/Login"} />
  }
  return <Layout />
};

function Cliente () {
  const {role} = useStateContext()
  if (role !== 'CLIENTE') {
    return <Navigate to={"/Login"} />
  }
  return <Layout />
}

function Ristoratore () {
  const {role} = useStateContext()
  if (role !== 'RISTORATORE') {
    return <Navigate to={"/Login"} />
  }
  return <Layout />
}

const router = createBrowserRouter([
    {
        path: '/ristoranti',
        element: <Layout Content={<Ristoranti />} />
    },
    {
        path: '/ristorante/:id',
        element: <Layout Content={<Ristorante />} />
    },
    {
        path: '/menu/:id',
        element: <Layout Content={<Menu />} />
    },
    {
        path: '/login',
        element: <Layout Content={<Login />} />,
    },
    {
        path: '/signup',
        element: <Layout Content={<SignUp />} />,
    },
    {
        path: '*',
        element: <Layout Content={<NotFound />} />,
    },
    {
        path: '/',
        element: <Autenticato />,
        children: [
            {
                path: '/dashboard',
                element: <Navigate to="/selezioneprofilo" />
            },
            {
                path: '/selezioneprofilo',
                element: <SelezioneProfilo />
            },
            {
                path: '/creazioneprofilocliente',
                element: <CreazioneProfiloCliente />
            },
            {
                path: '/creazioneprofiloristoratore',
                element: <CreazioneProfiloRistoratore />
            },
            {
                path: '/modificaprofilocliente/:id',
                element: <ModificaProfiloCliente />
            },
            {
                path: '/modificaprofiloristoratore/:id',
                element: <ModificaProfiloRistoratore/>
            },
            {
                path: '/modificainfoaccount',
                element: <ModificaInfoAccount />
            },
            {
                path: '*',
                element: <NotFound />
            }
        ]
    },
    {
        path: '/',
        element: <Cliente />,
        children: [

            // decommentare qui per dashboard
             {
                path: '/',
                element: <NotFound />
             },
            /*
            {
                path: '/ristoranti',
                element: <Ristoranti />
            },
            */
             {
                path: '/dashboardcliente',
                element: <NotFound />
             },
        ]
    },
    {
        path: '/',
        element: <Ristoratore />,
        children: [
            // decommentare qui per dashboard
            {
                path: '/',
                element: <Navigate to="/dashboardristoratore" />
            },
            /*
            {
                path: '/ristoranti',
                element: <Ristoranti />
            },
            */
            {
                path: '/dashboardristoratore',
                element: <RistoratoreDashboard />
            },
            {
                path: '/gestionemenu/:ristoratoreId',
                element: <GestioneMenu />
            },
            {
                path: '/creapietanza/:ristoratoreId',
                element: <FormPietanza />
            },
            {
                path: '/gestioneingredienti/:ristoratoreId',
                element: <GestioneIngredienti/>
            },
            {
                path: 'creaingrediente/:ristoratoreId',
                element: <FormIngrediente />
            },
        ]
    },
])

export default router;
