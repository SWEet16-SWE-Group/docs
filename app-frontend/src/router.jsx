import {createBrowserRouter, Navigate} from "react-router-dom";
import SignUp from "./views/SignUp.jsx";
import Login from "./views/Login";
import Ristoranti from "./views/Ristoranti";
import NotFound from "./views/NotFound.jsx";

import Layout from "./components/Layout"

import ModificaInfoAccount from "./views/ModificaInfoAccount";
import SelezioneProfilo from "./views/SelezioneProfilo";
import CreazioneProfiloRistoratore from "./views/CreazioneProfiloRistoratore";
import ModificaProfiloCliente from "./views/ModificaProfiloCliente";
import ModificaProfiloRistoratore from "./views/ModificaProfiloRistoratore";
import CreazioneProfiloCliente from "./views/CreazioneProfiloCliente.jsx";

const router = createBrowserRouter([
    {
        path: '/',
        element: <Layout />,
        children: [
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
        element: <Layout />,
        children: [

            // decommentare qui per dashboard
             {
                path: '/',
                element: <Navigate to="/dashboardcliente" />
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
        element: <Layout />,
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
                element: <NotFound />
             },
        ]
    },
    {
        path: '/',
        element: <Layout />,
        children: [
            {
                path: '/ristoranti',
                element: <Ristoranti />
            },
            {
                path: '/login',
                element: <Login />
            },
            {
                path: '/signup',
                element: <SignUp />
            },
            {
                path: '*',
                element: <NotFound />
            }
        ]
    },
])

export default router;
