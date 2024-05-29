import {useRef, useState} from "react";
import axiosClient from "../axios-client";

export default function ModificaInfoAccount() {

    const [AccountId, setAccountId] = useState(localStorage.getItem('USER_ID'))
    const [AccountEmail, setAccountEmail] = useState(null)

    const emailRef = useRef();
    const passwordRef = useRef();
    const passwordConfirmationRef = useRef();

    debugger;
    const getEmail = () => {

        const payload = [AccountId];
        axiosClient.post('/email',payload)
            .then(({data}) => {

            setAccountEmail(data.email)
            console.log(data);
            }
        );
    }

    return (
        <div>
            Info account
        </div>
    )



}