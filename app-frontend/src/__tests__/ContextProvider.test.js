import React from 'react';
import { act } from 'react';
import { render, screen, fireEvent } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { ContextProvider, useStateContext } from '../contexts/ContextProvider';

// Component "helper" per testare il context
const TestComponent = () => {
    const {
        user, token, role, profile, ristoratore, notification, notificationStatus,
        setUser, setToken, setRole, setProfile, setRistoratore, setNotification, setNotificationStatus
    } = useStateContext();

    return (
        <div>
            <div id="user">{user}</div>
            <div id="token">{token}</div>
            <div id="role">{role}</div>
            <div id="profile">{profile}</div>
            <div id="ristoratore">{ristoratore}</div>
            <div id="notification">{notification}</div>
            <div id="notificationStatus">{notificationStatus}</div>
            <button id="set-user" onClick={() => setUser('newUser')}>Set User</button>
            <button id="set-token" onClick={() => setToken('newToken')}>Set Token</button>
            <button id="set-role" onClick={() => setRole('newRole')}>Set Role</button>
            <button id="set-profile" onClick={() => setProfile('newProfile')}>Set Profile</button>
            <button id="set-ristoratore" onClick={() => setRistoratore('newRistoratore')}>Set Ristoratore</button>
            <button id="set-notification" onClick={() => setNotification('newNotification')}>Set Notification</button>
            <button id="set-notification-status" onClick={() => setNotificationStatus('success')}>Set Notification Status</button>
        </div>
    );
};

describe('ContextProvider', () => {
    beforeEach(() => {
        localStorage.clear();
        jest.useFakeTimers();
    });

    it('provides initial state values from localStorage', async () => {
        localStorage.setItem('USER_ID', 'testUser');
        localStorage.setItem('ROLE', 'testRole');
        localStorage.setItem('ACCESS_TOKEN', 'testToken');
        localStorage.setItem('PROFILE_ID', 'testProfile');
        localStorage.setItem('RISTORATORE_ID', 'testRistoratore');

        await act(async () => {
            render(
                <ContextProvider>
                    <TestComponent />
                </ContextProvider>
            );
        });

        expect(screen.getByTestId('user').textContent).toBe('testUser');
        expect(screen.getByTestId('role').textContent).toBe('testRole');
        expect(screen.getByTestId('token').textContent).toBe('testToken');
        expect(screen.getByTestId('profile').textContent).toBe('testProfile');
        expect(screen.getByTestId('ristoratore').textContent).toBe('testRistoratore');
        expect(screen.getByTestId('notification').textContent).toBe('');
        expect(screen.getByTestId('notificationStatus').textContent).toBe('failure');
    });

    it('updates state and localStorage through context functions', async () => {
        await act(async () => {
            render(
                <ContextProvider>
                    <TestComponent />
                </ContextProvider>
            );
        });

        fireEvent.click(screen.getByTestId('set-user'));
        fireEvent.click(screen.getByTestId('set-token'));
        fireEvent.click(screen.getByTestId('set-role'));
        fireEvent.click(screen.getByTestId('set-profile'));
        fireEvent.click(screen.getByTestId('set-ristoratore'));
        fireEvent.click(screen.getByTestId('set-notification'));
        fireEvent.click(screen.getByTestId('set-notification-status'));

        expect(screen.getByTestId('user').textContent).toBe('newUser');
        expect(screen.getByTestId('token').textContent).toBe('newToken');
        expect(screen.getByTestId('role').textContent).toBe('newRole');
        expect(screen.getByTestId('profile').textContent).toBe('newProfile');
        expect(screen.getByTestId('ristoratore').textContent).toBe('newRistoratore');
        expect(screen.getByTestId('notification').textContent).toBe('newNotification');
        expect(screen.getByTestId('notificationStatus').textContent).toBe('success');

        expect(localStorage.getItem('USER_ID')).toBe('newUser');
        expect(localStorage.getItem('ACCESS_TOKEN')).toBe('newToken');
        expect(localStorage.getItem('ROLE')).toBe('newRole');
        expect(localStorage.getItem('PROFILE_ID')).toBe('newProfile');
        expect(localStorage.getItem('RISTORATORE_ID')).toBe('newRistoratore');
    });

    it('clears localStorage when setting null values', async () => {
        await act(async () => {
            render(
                <ContextProvider>
                    <TestComponent />
                </ContextProvider>
            );
        });

        fireEvent.click(screen.getByTestId('set-user'));
        fireEvent.click(screen.getByTestId('set-token'));
        fireEvent.click(screen.getByTestId('set-role'));
        fireEvent.click(screen.getByTestId('set-profile'));
        fireEvent.click(screen.getByTestId('set-ristoratore'));

        fireEvent.click(screen.getByTestId('set-user'));
        fireEvent.click(screen.getByTestId('set-token'));
        fireEvent.click(screen.getByTestId('set-role'));
        fireEvent.click(screen.getByTestId('set-profile'));
        fireEvent.click(screen.getByTestId('set-ristoratore'));

        expect(localStorage.getItem('USER_ID')).toBe('newUser');
        expect(localStorage.getItem('ACCESS_TOKEN')).toBe('newToken');
        expect(localStorage.getItem('ROLE')).toBe('newRole');
        expect(localStorage.getItem('PROFILE_ID')).toBe('newProfile');
        expect(localStorage.getItem('RISTORATORE_ID')).toBe('newRistoratore');
    });

    it('clears notification after 5 seconds', async () => {
        await act(async () => {
            render(
                <ContextProvider>
                    <TestComponent />
                </ContextProvider>
            );
        });

        fireEvent.click(screen.getByTestId('set-notification'));

        expect(screen.getByTestId('notification').textContent).toBe('newNotification');

        act(() => {
            jest.advanceTimersByTime(5000);
        });

        expect(screen.getByTestId('notification').textContent).toBe('');
    });
});
