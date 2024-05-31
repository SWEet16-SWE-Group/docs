<<<<<<< HEAD
import * as React from "react";
import * as ReactDOM from "react-dom/client";
import {
  createBrowserRouter,
  RouterProvider,
} from "react-router-dom";
import "./index.css";
import Account,{loader as rootLoader, action as rootAction} from "./views/Account";
import EditClient from "./views/EditClient";

const router = createBrowserRouter([
  {
    path: "/",
    element:{
        path:"/",
        element:<Account />,
        loader : rootLoader,
        action :rootAction,
        children : [

  {
    path:"account/:clientId",
    element:<Client />,
  },
  {
    path: "account/:clientId/edit",
    element: <EditClient />,
    loader: contactLoader,
  },
],
},
  }
]);

ReactDOM.createRoot(document.getElementById("root")).render(
  <React.StrictMode>
    <RouterProvider router={router} />
  </React.StrictMode>
);
=======
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
>>>>>>> mvp-main
