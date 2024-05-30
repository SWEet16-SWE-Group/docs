import React from "react";
import ReactDOM from "react-dom/client";
import {RouterProvider} from "react-router-dom";
import router from "./router";
import {ContextProvider} from "./contexts/ContextProvider";
import "./index.css"
import "./scss/styles.sccs";
import * as bootstrap from 'bootstrap'

ReactDOM.createRoot(document.getElementById('root')).render(
    <React.StrictMode>
        <ContextProvider>
        <RouterProvider router={router} />
        </ContextProvider>
    </React.StrictMode>
)