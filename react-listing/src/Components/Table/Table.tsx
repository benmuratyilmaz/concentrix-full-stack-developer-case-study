import { useState } from "react";
import "./Table.css";
import type { User } from "../../Models";
import Modal from "../Modal";

type Props = {
  data: User[];
  query: string;
  onChange: (value: string) => void;
};

export default function Table({ data, query, onChange }: Props) {
  const [modal, setModal] = useState<User | null>(null);
  return (
    <>
      <section>
        <input
          type="text"
          placeholder="Search name"
          value={query}
          onChange={(e) => onChange(e.target.value)}
        />
        <ul className="user-list">
          {data.map((user) => (
            <li key={user.id} className="user-card">
              <article className="row">
                <div className="info">
                  <h3 className="name">{user.name}</h3>
                  <p className="meta">{user.email}</p>
                  <p className="meta">{user.company.name}</p>
                </div>
                <div className="actions">
                  <button
                    type="button"
                    className="button-list"
                    onClick={() => setModal(user)}
                  >
                    Detail
                  </button>
                </div>
              </article>
            </li>
          ))}
        </ul>
      </section>
      <Modal open={!!modal} onClose={() => setModal(null)} detail={modal} />
    </>
  );
}
