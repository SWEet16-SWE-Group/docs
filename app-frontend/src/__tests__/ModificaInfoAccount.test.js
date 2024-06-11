import React from 'react';
import { act } from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route , redirect } from 'react-router-dom';
import { ContextProvider , useStateContext } from '../contexts/ContextProvider';
import ModificaInfoAccount from '../views/ModificaInfoAccount';
import axiosClient from '../axios-client';
import axios from 'axios';

jest.mock('../axios-client');


jest.mock('../contexts/ContextProvider', () => {
    const originalModule = jest.requireActual('../contexts/ContextProvider');
    return {
        ...originalModule,
        useStateContext: jest.fn(),
    };
});


const renderWithContext = (component) => {
    
      return render(
        <ContextProvider>
            <MemoryRouter initialEntries={['/modificainfoaccount']}>
                <Routes>
                    <Route path="/" render={() => (
        <div>
          <h1>Home</h1>
        </div>)} />
                    <Route path="/modificainfoaccount" element={component} />
                </Routes>
            </MemoryRouter>
        </ContextProvider>
      );
    };

describe('Modifica info account test', () => {
    let mockUseStateContext;
    const user_id = "1";
    const user_role= "AUTENTICATO";
    beforeEach ( () => { 
     localStorage.setItem('USER_ID',user_id);
     localStorage.setItem("ROLE" , user_role);
     mockUseStateContext = {
        role : localStorage.getItem('ROLE'),
        setRole:jest.fn(),
        setNotificationStatus: jest.fn(),
        setNotification : jest.fn(),
    };
    useStateContext.mockReturnValue(mockUseStateContext);

    axiosClient.post.mockResolvedValueOnce({
        data : {
            id: localStorage.getItem('USER_ID'),
            email: 'tullio@gmail.com',
            password: 'password',
            password_confirmation: 'password'
        }
    });
    
});

afterEach(() => {
    jest.clearAllMocks();
});

    it('inital render goes well', async () => {

        renderWithContext(<ModificaInfoAccount/>);

        expect(axiosClient.post).toHaveBeenCalledWith('/user', {
            id: "1",
            role: 'AUTENTICATO',
        });

        await waitFor(() => {
            expect(screen.getByText('Modifica le informazioni relative al tuo account')).toBeInTheDocument();
            expect(screen.getByText('Modifica password:')).toBeInTheDocument();
            expect(screen.getByText('Modifica email:')).toBeInTheDocument();
            expect(screen.getByText('Elimina account')).toBeInTheDocument();
            expect(screen.getByRole('emailChanger',{'value': 'tullio@gmail.com'})).toBeInTheDocument();
        });
    });

    it('Showing user data fetching error', async () => {
        axiosClient.post.mockReset();
        axiosClient.post.mockRejectedValueOnce({
            response : {
                status : 422,
            },
        });
        renderWithContext(<ModificaInfoAccount/>);
        expect(axiosClient.post).toHaveBeenCalledWith('/user', {
            id: "1",
            role: 'AUTENTICATO',
        });
        await waitFor(() => {
        });

    });

    it('New email submission goes well', async () => {

        renderWithContext(<ModificaInfoAccount/>);

        act(() => {
            fireEvent.change(screen.getByRole('emailChanger'), { target: { value: 'tullio2.laVendetta@gmail.com' } });
          });

        expect(screen.getByRole('emailChanger',{'value':'tullio2.laVendetta@gmail.com'})).toBeInTheDocument();

        axiosClient.put.mockResolvedValueOnce({});

        act( () => {
            const oneOfManyButtons = screen.getAllByText('Salva');
            fireEvent.click(oneOfManyButtons[1]);
        });

        expect(axiosClient.put).toHaveBeenCalledWith('/useremail',{
            id: '1',
            role: 'AUTENTICATO',
            email: 'tullio2.laVendetta@gmail.com',
        });

         await waitFor( () => {
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Email modificata con successo');
        }); 

    });

    it('New email submission goes wrong!', async () => {
        renderWithContext(<ModificaInfoAccount/>);

        act(() => {
            fireEvent.change(screen.getByRole('emailChanger'), { target: { value: 'tullio2.laVendetta@gmail.com' } });
          });

        expect(screen.getByRole('emailChanger',{'value':'tullio2.laVendetta@gmail.com'})).toBeInTheDocument();
        axiosClient.put.mockRejectedValueOnce({
            response : {
                status : 422,
                data : {
                    errors : {
                        email : "La modifica dell'email non è andata a buon fine!"
                    }
                }
            }
        });

        act( () => {
            const oneOfManyButtons = screen.getAllByText('Salva');
            fireEvent.click(oneOfManyButtons[1]);
        });

        await waitFor(() => {
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('La modifica dell\'email non è andata a buon fine!');
        });
    });
    
    it('New password submission goes well', async () => {
        renderWithContext(<ModificaInfoAccount/>);

        act(() => {
            fireEvent.change(screen.getByRole('passwordChanger'), { target: { value: 'new password' } });
            fireEvent.change(screen.getByRole('passwordConfirmer'), { target: { value: 'new password' } });
          });

        axiosClient.put.mockResolvedValueOnce({});

        act( () => {
            const oneOfManyButtons = screen.getAllByText('Salva');
            fireEvent.click(oneOfManyButtons[0]);
        });

        expect(axiosClient.put).toHaveBeenCalledWith('/userpassword',{
            id: '1',
            role: 'AUTENTICATO',
            password: 'new password',
            password_confirmation: 'new password',
        });

         await waitFor( () => {
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('success');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Password modificata con successo');
        }); 
    });

    it('New password submission goes wrong!', async () => {
        renderWithContext(<ModificaInfoAccount/>);

        act(() => {
            fireEvent.change(screen.getByRole('passwordChanger'), { target: { value: 'new password' } });
            fireEvent.change(screen.getByRole('passwordConfirmer'),{target : { value : 'wrong new password'}});
          });

        axiosClient.put.mockRejectedValueOnce({
            response : {
                status : 422,
                data : {
                    errors : {
                        password : "La modifica della password non è andata a buon fine!"
                    }
                }
            }
        });

        act( () => {
            const oneOfManyButtons = screen.getAllByText('Salva');
            fireEvent.click(oneOfManyButtons[0]);
        });

        expect(axiosClient.put).toHaveBeenCalledWith('/userpassword',{
            id: '1',
            role: 'AUTENTICATO',
            password: 'new password',
            password_confirmation: 'wrong new password',
        });

        await waitFor(() => {
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('failure');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('La modifica della password non è andata a buon fine!');
        });
    });

    it('User account deletion' , async () => {

        axiosClient.delete.mockResolvedValueOnce({});
        renderWithContext(<ModificaInfoAccount/>);
        window.confirm = jest.fn(() => true);

        act( () => {
            fireEvent.click(screen.getByText('Elimina account'));
        });

        expect(window.confirm).toHaveBeenCalledWith("Sei sicuro di voler eliminare il tuo account?");
        expect(axiosClient.delete).toHaveBeenCalledWith('/user', {
            data : {
            "id": '1',
            "role": 'AUTENTICATO',
            }
        });
        await waitFor(() => {
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('success');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Account eliminato con successo');
            expect(localStorage.length).toBe(0);
        });       
    });
    
});