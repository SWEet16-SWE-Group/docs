import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import { ContextProvider, useStateContext } from '../contexts/ContextProvider';
import SignUp from '../views/SignUp';
import axiosClient from '../axios-client';
import { act } from 'react';

jest.mock('../axios-client');
jest.mock('../contexts/ContextProvider', () => {
    const originalModule = jest.requireActual('../contexts/ContextProvider');
    return {
        ...originalModule,
        useStateContext: jest.fn(),
    };
});


const renderWithContext = (component) => {
    act(() => {
        render(
            <ContextProvider>
                <MemoryRouter initialEntries={['/signup']}>
                    <Routes>
                        <Route path="/signup" element={component} />
                    </Routes>
                </MemoryRouter>
            </ContextProvider>
        );
    });
};

describe('SignUp testing...', () => {
    
     let mockUseStateContext;

     beforeEach ( () => {
        mockUseStateContext = {
            setUser: jest.fn(),
            setToken: jest.fn(),
            setRole : jest.fn() ,
            setNotification: jest.fn(),
            setNotificationStatus: jest.fn(),
        };
        useStateContext.mockReturnValue(mockUseStateContext);
     });
     afterEach( () => {
        jest.clearAllMocks();
     });

    it('SignUp form rendered correctly', () => {
        renderWithContext(<SignUp/>)

        expect(screen.getByText('Registrazione account')).toBeInTheDocument();
        expect(screen.getByText('Sei già registrato?')).toBeInTheDocument();
        expect(screen.getByText('Vai a login')).toBeInTheDocument();
        expect(screen.getByRole('textbox')).toBeInTheDocument();
    });

   it('SignUp goes smoothly', async () => {
        renderWithContext(<SignUp/>);

        axiosClient.post.mockResolvedValueOnce( {
            data : {
                user : {
                    id : '1'},
                role : 'AUTENTICATO',
                token : 'validToken',
            }
        });

        act( () => {
            fireEvent.change(screen.getByPlaceholderText('Email'), { target: { value: 'tullio@gmail.com' } });
            fireEvent.change(screen.getByPlaceholderText('Password'), { target: { value: 'Tullio 2:la vendetta' } });
            fireEvent.change(screen.getByPlaceholderText('Ripeti password'), { target: { value: 'Tullio 2:la vendetta' } });
            fireEvent.click(screen.getByText('Registrati'));
        });

        expect(axiosClient.post).toHaveBeenCalledWith('/signup', {
            email: 'tullio@gmail.com',
            password: 'Tullio 2:la vendetta',
            password_confirmation: 'Tullio 2:la vendetta',
        });
        await waitFor( () => {
            expect(mockUseStateContext.setUser).toHaveBeenCalledWith('1');
            expect(mockUseStateContext.setRole).toHaveBeenCalledWith('AUTENTICATO');
            expect(mockUseStateContext.setToken).toHaveBeenCalledWith('validToken');
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('success');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Registrazione effettuata con successo');
        });

    }); 

    it('SignUp goes wrong!', async () => {
        renderWithContext(<SignUp/>);

        axiosClient.post.mockRejectedValueOnce( {
            response : {
              status : 422 ,
              data : {
                errors : {
                    error : ['Attenzione, la registrazione non è andata a buon fine!']
                }
        }
        }});

        act( () => {
            fireEvent.click(screen.getByText('Registrati'));
        });

        await waitFor( () => {
            expect(screen.getByText('Attenzione, la registrazione non è andata a buon fine!')).toBeInTheDocument();
        });
    }); 
});