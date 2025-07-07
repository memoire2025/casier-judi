import { Navigate, Outlet } from "react-router-dom";

const PrivateRoute = () => {
  const token = localStorage.getItem("accessToken-casier");

  return token ? <Outlet /> : <Navigate to="/" />;
};

export default PrivateRoute;