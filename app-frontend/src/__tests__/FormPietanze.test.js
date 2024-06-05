import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import { ContextProvider, useStateContext } from '../contexts/ContextProvider';
import FormPietanza from '../views/FormPietanza.jsx';
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
      return render(
        <ContextProvider>
            <MemoryRouter initialEntries={['/creapietanza/1']}>
                <Routes>
                    <Route path="/creapietanza/:ristoratoreId" element={component} />
                </Routes>
            </MemoryRouter>
        </ContextProvider>
      );
    });
};

describe('FormIngrediente', () => {
    const ristoratoreId = '1';
    let mockUseStateContext;

    beforeEach(() => {
        mockUseStateContext = {
            setNotification: jest.fn(),
            setNotificationStatus: jest.fn(),
        };
        useStateContext.mockReturnValue(mockUseStateContext);
    });

    afterEach(() => {
        jest.clearAllMocks();
    });

    it('renders the form correctly', () => {
        renderWithContext(<FormPietanza />);

        expect(screen.getByText('Aggiungi Pietanza')).toBeInTheDocument();
        expect(screen.getByLabelText('Nome Pietanza')).toBeInTheDocument();
        expect(screen.getByRole('button', { name: 'Aggiungi' })).toBeInTheDocument();
        expect(screen.getByRole('button', { name: 'Annulla' })).toBeInTheDocument();
    });

    it('handles input changes', () => {
        renderWithContext(<FormPietanza />);

        const input = screen.getByLabelText('Nome Pietanza');
        fireEvent.change(input, { target: { value: 'Pasta' } });
        expect(input.value).toBe('Pasta');
    });

    it('handles successful form submission', async () => {
        const ristoratoreId = '1';
        axiosClient.post.mockResolvedValueOnce({ data: { status: 'success' } });
        renderWithContext(<FormPietanza />);
    
        act(() => {
            fireEvent.change(screen.getByLabelText('Nome Pietanza'), { target: { value: 'Pasta' } });
            fireEvent.click(screen.getByRole('button', { name: 'Aggiungi' }));
        });
    
        await waitFor(() => {
            expect(axiosClient.post).toHaveBeenCalledWith('/pietanze', { ristoratore: ristoratoreId, nome: 'Pasta' });
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('success');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Pietanza aggiunta con successo.');
            //expect(navigate).toHaveBeenCalledWith(`/gestioneingredienti/${ristoratoreId}`);
        });
    });
    
    

    it('handles form submission errors', async () => {
        axiosClient.post.mockRejectedValueOnce(new Error('API Error'));
        renderWithContext(<FormPietanza />);
        act(() => {
            fireEvent.change(screen.getByLabelText('Nome Pietanza'), { target: { value: 'Pasta' } });
            fireEvent.click(screen.getByRole('button', { name: 'Aggiungi' }));
        });
        
        await waitFor(() => {
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('error');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Errore durante l\'aggiunta della pietanza.');
            expect(screen.getByText('Errore durante l\'aggiunta della pietanza. Per favore riprova.')).toBeInTheDocument();
        });
    });
});
