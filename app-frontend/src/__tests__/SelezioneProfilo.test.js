import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import { ContextProvider, useStateContext } from '../contexts/ContextProvider';
import SelezionaProfilo from '../views/SelezioneProfilo';
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
    
     act(() => {   render(
            <ContextProvider>
                <MemoryRouter initialEntries={['/selezionaprofilo']}>
                    <Routes>
                        <Route path="/selezionaprofilo" element={component} />
                    </Routes>
                </MemoryRouter>
            </ContextProvider>
        );
    });
    
};

describe('Testing SelezionePofilo', () => {
    const user_id = '1';
    let mockUseStateContext;

    beforeEach(() => {
        localStorage.setItem('USER_ID', user_id);

        mockUseStateContext = {
            role : 'AUTENTICATO' ,
            setRole : jest.fn(),
            setProfile : jest.fn(),
            setRistoratore : jest.fn(),
            setNotification: jest.fn(),
            setNotificationStatus: jest.fn(),
        };
        useStateContext.mockReturnValue(mockUseStateContext);
    });

    afterEach(() => {
    //    jest.clearAllMocks();
    });

    it('Profiles List rendered correctly', async () => {
        axiosClient.post.mockResolvedValueOnce({
            data : {
                clienti : {
                    profile : {
                   id : '1' ,
                   nome : 'Todaro',
                    }
                   
                },
                ristoratori : {
                    profile : {
                        id : '2',
                        nome : 'Da Luigino'
                    }
                },
            }
        });

        renderWithContext(<SelezionaProfilo/>);

        expect(axiosClient.post).toHaveBeenCalledWith('/profiles',{
            id : '1',
            role : 'AUTENTICATO',
        });

        await waitFor(() => {
            expect(screen.getByText('Crea nuovo profilo cliente')).toBeInTheDocument();
            expect(screen.getByText('Crea nuovo profilo ristoratore')).toBeInTheDocument();
            expect(screen.getByText('Todaro')).toBeInTheDocument();
            expect(screen.getByText('Da Luigino')).toBeInTheDocument();
    });
     //   expect(screen.getByText()).toBeInTheDocument();

    });

    it('Empty profiles List rendered correctly', async () => {
        axiosClient.post.mockResolvedValueOnce({
            data : {
                clienti : {
                    }
                   
                },
                ristoratori : {
                },
            
        });

        renderWithContext(<SelezionaProfilo/>);

        expect(axiosClient.post).toHaveBeenCalledWith('/profiles',{
            id : '1',
            role : 'AUTENTICATO',
        });

        await waitFor(() => {
            expect(screen.getByText('Non è presente nessun profilo, creane uno!')).toBeInTheDocument();
    });
    });
   
    it('Testing profile selection', async() => {
        axiosClient.post.mockResolvedValueOnce({
            data : {
                clienti : [
                   {
                   id : '1' ,
                   nome : 'Todaro',
                   }
                   
                ],
                ristoratori : [

                    {
                        id : '2',
                        nome : 'Da Luigino'
                    }
                ],
            }
        });

        renderWithContext(<SelezionaProfilo/>);
        
        await waitFor( () => {
            act( () => {
                const selectionLinks=screen.getAllByText('Seleziona');
                fireEvent.click(selectionLinks[0]);
            });
            expect(mockUseStateContext.setRole).toHaveBeenCalledWith('CLIENTE');
            expect(mockUseStateContext.setProfile).toHaveBeenCalledWith('1');
        });
    });
    it('Testing profile modification', async () => {});
    it('Testing profile deletion', async () => {});
    it('Profile deletion goes wrong', async () => {});

})
