import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import { ContextProvider, useStateContext } from '../contexts/ContextProvider';
import FormIngrediente from '../views/FormIngredienti.jsx';
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
            <MemoryRouter initialEntries={['/creaingrediente/1']}>
                <Routes>
                    <Route path="/creaingrediente/:ristoratoreId" element={component} />
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
        axiosClient.get.mockResolvedValueOnce({
            data : [
                {
                    id:'latticini_id',
                    nome:'latticini',
                },
                {
                    id:'graminacee_id',
                    nome:'graminacee',
                },
            ]
        });

        mockUseStateContext = {
            setNotification: jest.fn(),
            setNotificationStatus: jest.fn(),
        };
        useStateContext.mockReturnValue(mockUseStateContext);
    });

    afterEach(() => {
        jest.clearAllMocks();
    });

    it('renders the form correctly',async () => {
        renderWithContext(<FormIngrediente />);

        expect(screen.getByText('Aggiungi Ingrediente')).toBeInTheDocument();
        expect(screen.getByLabelText('Nome Ingrediente')).toBeInTheDocument();
        expect(screen.getByRole('button', { name: 'Aggiungi' })).toBeInTheDocument();
        expect(screen.getByRole('button', { name: 'Annulla' })).toBeInTheDocument();

        await waitFor(()=> {
            expect(screen.getByText('graminacee')).toBeInTheDocument();
            expect(screen.getByText('latticini')).toBeInTheDocument();
        });
    });

    it('Testing changing idea', () => {
        renderWithContext(<FormIngrediente />);

        expect(screen.getByText('Aggiungi Ingrediente')).toBeInTheDocument();
        expect(screen.getByLabelText('Nome Ingrediente')).toBeInTheDocument();
        expect(screen.getByRole('button', { name: 'Aggiungi' })).toBeInTheDocument();
        expect(screen.getByRole('button', { name: 'Annulla' })).toBeInTheDocument();

        act(() => {
            fireEvent.click(screen.getByRole('button', { name: 'Annulla' }));
        });
    });

    it('Allergeni fetching goes wrong',async () => {
        jest.clearAllMocks();
        axiosClient.get.mockRejectedValueOnce({});
        renderWithContext(<FormIngrediente />);

    });

    it('handles input changes', () => {
        renderWithContext(<FormIngrediente />);

        const input = screen.getByLabelText('Nome Ingrediente');
        act(() => {
            fireEvent.change(input, { target: { value: 'Pomodoro' } });
        });
        expect(input.value).toBe('Pomodoro');
    });

    it('handles successful form submission', async () => {
        const ristoratoreId = '1';
        axiosClient.post.mockResolvedValueOnce({ data: { status: 'success' } });
        renderWithContext(<FormIngrediente />);
        
        await waitFor(()=> {
            expect(screen.getByText('latticini')).toBeInTheDocument();
        });

        act(() => {
            fireEvent.change(screen.getByLabelText('Nome Ingrediente'), { target: { value: 'Pomodoro' } });
            fireEvent.click(screen.getByText('latticini'));
            fireEvent.click(screen.getByRole('button', { name: 'Aggiungi' }));
        });
    
        await waitFor(() => {
            expect(axiosClient.post).toHaveBeenCalledWith('/ingredienti', { ristoratore: ristoratoreId, allergie: ['latticini_id'], nome: 'Pomodoro' });
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('success');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Ingrediente aggiunto con successo.');
            //expect(navigate).toHaveBeenCalledWith(`/gestioneingredienti/${ristoratoreId}`);
        });
    });
    
    

    it('handles form submission errors', async () => {
        axiosClient.post.mockRejectedValueOnce(new Error('API Error'));
        renderWithContext(<FormIngrediente />);
        act(() => {
            fireEvent.change(screen.getByLabelText('Nome Ingrediente'), { target: { value: 'Pomodoro' } });
            fireEvent.click(screen.getByRole('button', { name: 'Aggiungi' }));
        });
        
        await waitFor(() => {
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('error');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Errore durante l\'aggiunta dell\'ingrediente.');
            expect(screen.getByText('Errore durante l\'aggiunta dell\'ingrediente. Per favore riprova.')).toBeInTheDocument();
        });
    });
});
