import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import axiosClient from '../axios-client';
import { useStateContext } from '../contexts/ContextProvider';
import DivisioneContoPagamento from '../views/DivisioneContoPagamento';

jest.mock('../axios-client');
jest.mock('../contexts/ContextProvider', () => {
    const originalModule = jest.requireActual('../contexts/ContextProvider');
    return {
        ...originalModule,
        useStateContext: jest.fn(),
    };
});

const renderWithContext = (component) => {
    render(
        <MemoryRouter initialEntries={['/divisione-conto/123']}>
            <Routes>
                <Route path="/divisione-conto/:id" element={component} />
            </Routes>
        </MemoryRouter>
    );
};

describe('DivisioneContoPagamento', () => {
    let mockUseStateContext;

    beforeEach(() => {
        mockUseStateContext = {
            user: {},
            profile: '123',
            token: 'token',
            role: 'CLIENTE',
            notification: null,
            notificationStatus: null,
            setUser: jest.fn(),
            setToken: jest.fn(),
            setRole: jest.fn(),
        };
        useStateContext.mockReturnValue(mockUseStateContext);

        axiosClient.get.mockResolvedValueOnce({
            data: {
                divisione_conto: null,
                nome: 'Prenotazione Test',
                orario: '2024-01-01',
            },
        });
    });

    afterEach(() => {
        jest.clearAllMocks();
    });

    it('renders the component correctly', async () => {
        renderWithContext(<DivisioneContoPagamento />);

        expect(await screen.findByText('Prenotazione Test')).toBeInTheDocument();
        expect(screen.getByText('Dettagli')).toBeInTheDocument();
        expect(screen.getByText('Data: 2024-01-01')).toBeInTheDocument();
    });

    it('handles setting "Equo" division mode', async () => {
        axiosClient.post.mockResolvedValueOnce({ data: { divisione_conto: 'Equo' } });

        renderWithContext(<DivisioneContoPagamento />);

        fireEvent.click(await screen.findByText('Equo'));

        await waitFor(() => {
            expect(axiosClient.post).toHaveBeenCalledWith('/set_divisioneconto/123', { divisione_conto: 'Equo' });
        });

        await waitFor(() => {
            expect(screen.getByText('Divisione conto: Equo')).toBeInTheDocument();
        });
    });

    it('handles setting "Proporzionale" division mode', async () => {
        axiosClient.post.mockResolvedValueOnce({ data: { divisione_conto: 'Proporzionale' } });

        renderWithContext(<DivisioneContoPagamento />);

        fireEvent.click(await screen.findByText('Proporzionale'));

        await waitFor(() => {
            expect(axiosClient.post).toHaveBeenCalledWith('/set_divisioneconto/123', { divisione_conto: 'Proporzionale' });
        });

        await waitFor(() => {
            expect(screen.getByText('Divisione conto: Proporzionale')).toBeInTheDocument();
        });
    });

    it('displays payments for "Equo" mode', async () => {
        axiosClient.get
            .mockResolvedValueOnce({
                data: { divisione_conto: 'Equo', nome: 'Prenotazione Test', orario: '2024-01-01' },
            })
            .mockResolvedValueOnce({
                data: [{ id: '1', cliente: 'Cliente 1', pagamento_c: 'NON_PAGATO', cid: '123' }],
            });

        axiosClient.post.mockResolvedValueOnce({
            data: { divisione_conto: 'Equo' },
        });

        renderWithContext(<DivisioneContoPagamento />);

        fireEvent.click(await screen.findByText('Equo'));

        await waitFor(() => {
            expect(screen.getByText('Divisione conto: Equo')).toBeInTheDocument();
            expect(screen.getByText('Pagamenti')).toBeInTheDocument();
        });
    });

    it('displays payments for "Proporzionale" mode', async () => {
        axiosClient.get
            .mockResolvedValueOnce({
                data: { divisione_conto: 'Proporzionale', nome: 'Prenotazione Test', orario: '2024-01-01' },
            })
            .mockResolvedValueOnce({
                data: [{ oid: '1', cliente: 'Cliente 1', pietanza: 'Pietanza 1', aggiunte: '', rimozioni: '', pagamento_o: 'NON_PAGATO', cid: '123' }],
            });

        axiosClient.post.mockResolvedValueOnce({
            data: { divisione_conto: 'Proporzionale' },
        });

        renderWithContext(<DivisioneContoPagamento />);

        fireEvent.click(await screen.findByText('Proporzionale'));

        await waitFor(() => {
            expect(screen.getByText('Divisione conto: Proporzionale')).toBeInTheDocument();
            expect(screen.getByText('Pagamenti')).toBeInTheDocument();
        });
    });
/*
    it('handles payment marking for "Equo" mode', async () => {
        axiosClient.get
            .mockResolvedValueOnce({
                data: { divisione_conto: 'Equo', nome: 'Prenotazione Test', orario: '2024-01-01' },
            })
            .mockResolvedValueOnce({
                data: [{ id: '1', cliente: 'Cliente 1', pagamento_c: 'NON_PAGATO', cid: '123' }],
            });

        axiosClient.post.mockResolvedValueOnce({
            data: { divisione_conto: 'Equo' },
        });

        renderWithContext(<DivisioneContoPagamento />);

        fireEvent.click(await screen.findByText('Equo'));

        await waitFor(() => {
            expect(axiosClient.post).toHaveBeenCalledWith('/paga_invito/1', {});
        });
    });

    it('handles payment marking for "Proporzionale" mode', async () => {
        axiosClient.get
            .mockResolvedValueOnce({
                data: { divisione_conto: 'Proporzionale', nome: 'Prenotazione Test', orario: '2024-01-01' },
            })
            .mockResolvedValueOnce({
                data: [{ oid: '1', cliente: 'Cliente 1', pietanza: 'Pietanza 1', aggiunte: '', rimozioni: '', pagamento_o: 'NON_PAGATO', cid: '123' }],
            });

        axiosClient.post.mockResolvedValueOnce({
            data: { divisione_conto: 'Proporzionale' },
        });

        renderWithContext(<DivisioneContoPagamento />);

        // Simulate setting the division mode to "Proporzionale"
        fireEvent.click(await screen.findByText('Proporzionale'));

        // Simulate clicking the "Paga" button
        fireEvent.click(await screen.findByText('Paga'));

        await waitFor(() => {
            expect(axiosClient.post).toHaveBeenCalledWith('/paga_ordinazione/1', {});
        });
    });
    */
});
